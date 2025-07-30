<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;
use App\Models\Chat;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);

    if (!$chat) {
        Log::info("Chat not found for channel authorization", ['chatId' => $chatId]);
        return false;
    }

    // Debug logging for role-specific issues
    $isPatientAuthorized = $user->id == $chat->patient_id;
    $isDoctorAuthorized = $user->id == $chat->doctor_id;
    $isAuthorized = $isPatientAuthorized || $isDoctorAuthorized;
    
    Log::info("Channel authorization debug", [
        'userId' => $user->id,
        'userRole' => $user->role ? $user->role->name : 'no_role',
        'chatId' => $chatId,
        'patientId' => $chat->patient_id,
        'doctorId' => $chat->doctor_id,
        'isPatientAuthorized' => $isPatientAuthorized,
        'isDoctorAuthorized' => $isDoctorAuthorized,
        'isAuthorized' => $isAuthorized
    ]);

    // User can join channel if they are either the patient or the doctor in this chat
    return $isAuthorized;
});
