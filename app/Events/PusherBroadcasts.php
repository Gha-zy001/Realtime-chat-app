<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
// use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadCasts implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public string $message;
  public User $user;
  public string $channelName;

  /**
   * Create a new event instance.
   */
  public function __construct(string $message, User $user, string $channelName)
  {
    $this->message = $message;
    $this->user = $user;
    $this->channelName = $channelName;
  }

  /**
   * Get the channels the event should broadcast on.
   *
   * @return array<int, \Illuminate\Broadcasting\Channel>
   */
  public function broadcastOn(): array
  {
    return [new Channel($this->channelName)];
  }

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
