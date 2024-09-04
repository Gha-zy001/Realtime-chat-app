<?php

namespace App\Http\Controllers\Api;

use App\Events\PusherBroadCasts;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
  public function getUsers()
  {
    $users = User::where('id', '!=', Auth::id())->get();
    return response()->json($users);
  }

  public function getMessages($userId)
  {
    // $messages = Message::where('receiver' ,'=', Auth::id())->get();
    $messages = Message::where(function ($query) use ($userId) {
      $query->where('sender', Auth::id())->where('receiver', $userId);
    })->orWhere(function ($query) use ($userId) {
      $query->where('sender', $userId)->where('receiver', Auth::id());
    })->orderBy('created_at', 'asc')->get();

    return response()->json($messages);
  }

  public function sendMessage(Request $request)
  {
    $senderId = Auth::id();
    $receiverId = $request->get('receiver');
    $messageText = $request->get('message');

    $message = Message::create([
      'sender' => $senderId,
      'receiver' => $receiverId,
      'message' => $messageText,
    ]);

    $channelName = 'chat.' . min($senderId, $receiverId) . '.' . max($senderId, $receiverId);

    $user = Auth::user();
    broadcast(new PusherBroadCasts($messageText, $user, $channelName))->toOthers();

    return response()->json([
      'status' => 'Message sent successfully!',
      'message' => $message,
    ]);
  }
}
