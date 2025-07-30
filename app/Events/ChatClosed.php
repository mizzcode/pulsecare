<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatClosed implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $chat;

  public function __construct(Chat $chat)
  {
    $this->chat = $chat;
  }

  public function broadcastOn(): array
  {
    return [
      new PrivateChannel('chat.' . $this->chat->id),
    ];
  }

  public function broadcastWith(): array
  {
    $closerRole = $this->chat->closedBy ? $this->chat->closedBy->role->name : 'dokter';

    return [
      'chat_id' => $this->chat->id,
      'status' => $this->chat->status,
      'closed_by' => $this->chat->closed_by,
      'closed_at' => $this->chat->closed_at ? $this->chat->closed_at->format('Y-m-d H:i:s') : null,
      'close_reason' => $this->chat->close_reason,
      'message' => 'Chat telah ditutup oleh ' . $closerRole,
    ];
  }

  public function broadcastAs(): string
  {
    return 'chat.closed';
  }
}