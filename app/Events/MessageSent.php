<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $chatMessage;

  public function __construct(ChatMessage $chatMessage)
  {
    $this->chatMessage = $chatMessage;
  }

  public function broadcastOn(): array
  {
    return [
      new PrivateChannel('chat.' . $this->chatMessage->chat_id),
    ];
  }

  public function broadcastWith(): array
  {
    return [
      'id' => $this->chatMessage->id,
      'message' => $this->chatMessage->message,
      'sender_id' => $this->chatMessage->sender_id,
      'sender_name' => $this->chatMessage->sender->name,
      'created_at' => $this->chatMessage->created_at->format('H:i'),
      'chat_id' => $this->chatMessage->chat_id,
    ];
  }

  public function broadcastAs(): string
  {
    return 'message.sent';
  }
}
