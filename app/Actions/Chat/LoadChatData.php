<?php

namespace App\Actions\Chat;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class LoadChatData
{
  public function execute(?User $receiver): array
  {
    $users = User::where('id', '!=', Auth::id())->get();
    $messages = collect();

    if ($receiver) {
      $messages = Message::where(function ($q) use ($receiver) {
        $q->where('sender', Auth::id())->where('receiver', $receiver->id);
      })->orWhere(function ($q) use ($receiver) {
        $q->where('sender', $receiver->id)->where('receiver', Auth::id());
      })->orderBy('created_at')->get();
    }

    return [
      'authUser' => Auth::user(),
      'users' => $users,
      'receiver' => $receiver,
      'messages' => $messages,
    ];
  }
}
