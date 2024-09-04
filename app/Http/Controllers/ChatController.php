<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Events\PusherBroadcast;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
  public function index()
  {
    $users = User::where('id', '!=', Auth::id())->get();
    $receiver = User::findOrFail(1);
    return view('index', ['authUser' => Auth::user(), 'users' => $users, 'receiver' => $receiver]);
  }

  public function chat($userId)
  {
    $receiver = User::findOrFail($userId);
    $users = User::where('id', '!=', Auth::id())->get();
    return view('index', ['authUser' => Auth::user(), 'receiver' => $receiver,'users' => $users]);
  }

  public function broadCast(Request $request)
  {
    $senderId = auth()->id();
    $receiverId = $request->get('receiver_id');
    $user = Auth::user();
    broadcast(new PusherBroadcast($request->get('message'),$user))->toOthers();
    return view('chat.layouts.broadcast', [
      'message' => $request->get('message'),
      'user' => $user
    ]);
  }

  public function receive(Request $request)
  {
    return view('chat.layouts.receive', [
      'message' => $request->get('message'),
      'user' => Auth::user()
    ]);
  }
}
