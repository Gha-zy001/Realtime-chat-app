<?php

namespace App\Actions\Chat;

use Illuminate\Http\Request;

class RenderReceived
{
  public function __invoke(Request $request)
  {
    return view('chat.partials.receive', [
      'message' => $request->get('message'),
      'user' => $request->get('user'),
    ]);
  }
}
