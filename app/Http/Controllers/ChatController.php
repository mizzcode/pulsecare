<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\User;
use App\Events\MessageSent;
use App\Events\ChatClosed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Check if user is participant in chat
     */
    private function isUserParticipant(Chat $chat, $userId): bool
    {
        return $chat->patient_id == $userId || $chat->doctor_id == $userId;
    }

    // Halaman pilih dokter (untuk pasien) atau dashboard chat (untuk dokter)
    public function doctors()
    {
        $user = Auth::user();

        // Jika user adalah dokter, redirect ke chat index
        if ($user->isDoctor()) {
            return redirect()->route('chat.index');
        }

        // Jika pasien, tampilkan list dokter
        $doctors = User::where('role_id', 2)
            ->with('role')
            ->get();

        return view('chat.doctors', compact('doctors'));
    }

    // Mulai chat dengan dokter
    public function startChat(Request $request, User $doctor)
    {
        if (!$doctor->isDoctor()) {
            abort(404, 'Doctor not found');
        }

        $patient = Auth::user();

        // Cek apakah sudah ada chat aktif dengan dokter ini
        $chat = Chat::where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->where('status', 'active')
            ->first();

        // Jika belum ada, buat chat baru
        if (!$chat) {
            $chat = Chat::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'status' => 'active',
                'last_message_at' => now()
            ]);
        }

        return redirect()->route('chat.room', $chat->id);
    }

    // Halaman chat room
    public function room(Chat $chat)
    {
        $user = Auth::user();

        Log::info('Chat room access attempt', [
            'user_id' => $user->id,
            'user_id_type' => gettype($user->id),
            'chat_patient_id' => $chat->patient_id,
            'chat_patient_id_type' => gettype($chat->patient_id),
            'chat_doctor_id' => $chat->doctor_id,
            'chat_doctor_id_type' => gettype($chat->doctor_id),
            'is_patient' => $chat->patient_id == $user->id,
            'is_doctor' => $chat->doctor_id == $user->id,
            'user_role' => $user->role->name ?? 'unknown'
        ]);

        // Pastikan user adalah bagian dari chat ini
        if (!$this->isUserParticipant($chat, $user->id)) {
            Log::warning('Unauthorized chat access', [
                'user_id' => $user->id,
                'chat_id' => $chat->id,
                'patient_id' => $chat->patient_id,
                'doctor_id' => $chat->doctor_id,
                'user_role' => $user->role->name ?? 'unknown'
            ]);
            abort(403, 'Unauthorized access to this chat');
        }

        // Load messages dengan sender info
        $messages = $chat->messages()->with('sender')->get();

        // Mark messages sebagai read untuk user ini
        $chat->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        $otherUser = $chat->patient_id == $user->id ? $chat->doctor : $chat->patient;

        return view('chat.chat-room', compact('chat', 'messages', 'otherUser'));
    }

    // Kirim pesan
    public function sendMessage(Request $request, Chat $chat)
    {
        $user = Auth::user();

        // Pastikan user adalah bagian dari chat ini
        if (!$this->isUserParticipant($chat, $user->id)) {
            abort(403, 'Unauthorized access to this chat');
        }

        // Cek apakah chat masih aktif
        if (!$chat->isActive()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chat ini sudah ditutup. Tidak dapat mengirim pesan.'
                ], 400);
            }
            return back()->with('error', 'Chat ini sudah ditutup. Tidak dapat mengirim pesan.');
        }

        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $message = ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->message,
            'type' => 'text'
        ]);

        // Update last_message_at di chat
        $chat->update(['last_message_at' => now()]);

        // Load sender relationship and broadcast the message
        $message->load('sender');

        // Broadcast message to other participants
        try {
            broadcast(new MessageSent($message))->toOthers();
            Log::info('Message broadcasted successfully', ['message_id' => $message->id]);
        } catch (\Exception $e) {
            Log::error('Failed to broadcast message', ['error' => $e->getMessage()]);
        }

        // Return JSON response untuk AJAX
        if ($request->ajax()) {
            Log::info('Sending message response', [
                'message_id' => $message->id,
                'sender_id' => $user->id,
                'message' => $message->message
            ]);

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_name' => $user->name,
                    'sender_id' => $user->id,
                    'created_at' => $message->created_at->toISOString(),
                    'is_own' => true
                ]
            ]);
        }

        return back();
    }

    // List chat untuk user
    public function index()
    {
        $user = Auth::user();

        if ($user->isDoctor()) {
            // Jika dokter, tampilkan chat dengan pasien yang aktif
            $chats = Chat::where('doctor_id', $user->id)
                ->where('status', 'active')
                ->with(['patient', 'latestMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        } else {
            // Jika pasien, tampilkan chat dengan dokter yang aktif
            $chats = Chat::where('patient_id', $user->id)
                ->where('status', 'active')
                ->with(['doctor', 'latestMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        }

        return view('chat.index', compact('chats'));
    }

    // History chat (status closed)
    public function history()
    {
        $user = Auth::user();

        if ($user->isDoctor()) {
            // Jika dokter, tampilkan chat dengan pasien yang sudah closed
            $chats = Chat::where('doctor_id', $user->id)
                ->where('status', 'closed')
                ->with(['patient', 'latestMessage'])
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            // Jika pasien, tampilkan chat dengan dokter yang sudah closed
            $chats = Chat::where('patient_id', $user->id)
                ->where('status', 'closed')
                ->with(['doctor', 'latestMessage'])
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        return view('chat.history', compact('chats'));
    }

    // Get messages untuk AJAX
    public function getMessages(Chat $chat)
    {
        $user = Auth::user();

        if (!$this->isUserParticipant($chat, $user->id)) {
            abort(403);
        }

        $messages = $chat->messages()
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get()
            ->reverse()
            ->values();

        return response()->json($messages);
    }

    // Close chat
    public function closeChat(Chat $chat)
    {
        $user = Auth::user();

        // Pastikan user adalah bagian dari chat ini
        if (!$this->isUserParticipant($chat, $user->id)) {
            abort(403, 'Unauthorized access to this chat');
        }

        // Update status chat menjadi closed
        $chat->close($user->id);

        // Load relasi closedBy dengan role untuk broadcast
        $chat->load('closedBy.role');

        // Broadcast chat closed event untuk memberitahu semua user di chat
        broadcast(new ChatClosed($chat))->toOthers();

        return redirect()->route('chat.index')->with('success', 'Chat telah ditutup dan dipindahkan ke riwayat.');
    }
}