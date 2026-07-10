<?php

namespace App\Actions\Chat;

use App\Models\User;

class ShowUserChat
{
  public function __construct(private LoadChatData $loadChatData) {}

  public function __invoke($userId)
  {
    $receiver = User::findOrFail($userId);

    if ($receiver->id === auth()->id()) {
      return redirect()->route('chat.index');
    }

    $data = $this->loadChatData->execute($receiver);

    return view('index', $data);
  }
}
