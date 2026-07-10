<?php

namespace App\Actions\Chat;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ShowChatPage
{
  public function __construct(private LoadChatData $loadChatData) {}

  public function __invoke()
  {
    $receiver = User::where('id', '!=', Auth::id())->first();

    return view('index', $this->loadChatData->execute($receiver));
  }
}
