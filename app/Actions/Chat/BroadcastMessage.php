<?php

namespace App\Actions\Chat;

use App\Events\PusherBroadcast;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastMessage
{
  public function __invoke(Request $request)
  {
    $user = Auth::user();
    $message = $request->get('message');

    Message::create([
      'sender' => $user->id,
      'receiver' => $request->get('receiver_id', 0),
      'message' => $message,
    ]);

    broadcast(new PusherBroadcast($message, $user))->toOthers();

    return view('chat.partials.broadcast', [
      'message' => $message,
    ]);
  }
}
