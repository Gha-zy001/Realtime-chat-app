<?php

namespace App\Http\Controllers;

use App\Actions\Chat\BroadcastMessage;
use App\Actions\Chat\RenderReceived;
use App\Actions\Chat\ShowChatPage;
use App\Actions\Chat\ShowUserChat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
  public function index(ShowChatPage $action)
  {
    return $action();
  }

  public function chat($userId, ShowUserChat $action)
  {
    return $action($userId);
  }

  public function broadCast(Request $request, BroadcastMessage $action)
  {
    return $action($request);
  }

  public function receive(Request $request, RenderReceived $action)
  {
    return $action($request);
  }
}
