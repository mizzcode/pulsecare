<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'status',
        'last_message_at',
        'closed_at',
        'closed_by'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'closed_at' => 'datetime'
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }

    public function latestMessage(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->latest();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('patient_id', $userId)->orWhere('doctor_id', $userId);
    }

    /**
     * Close this chat
     */
    public function close($closedBy = null)
    {
        $this->update([
            'status' => 'closed',
            'closed_at' => now(),
            'closed_by' => $closedBy
        ]);
    }

    /**
     * Check if chat is closed
     */
    public function isClosed()
    {
        return $this->status === 'closed';
    }

    /**
     * Check if chat is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get formatted closed date
     */
    public function getClosedDateAttribute()
    {
        return $this->closed_at ? $this->closed_at->format('d M Y H:i') : null;
    }
}
