<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;
  public string $message;
  public User $user;

  /**
   * Create a new event instance.
   */
  public function __construct(string $message, User $user)
  {
    $this->message = $message;
    $this->user = $user;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */

  public function broadcastOn(): array
  {
    return ['public'];
  }

  // public function broadcastAs(): string
  //   {
  //       return 'chat.message';
  //   }
  public function broadcastAs(): string
  {
    return 'chat';
  }

  public function broadcastWith(): array
  {
    return [
      'message' => $this->message,
      'user' => [
        'name' => $this->user->name,
      ],
      'timestamp' => now()->toDateTimeString(),
    ];
  }
}
