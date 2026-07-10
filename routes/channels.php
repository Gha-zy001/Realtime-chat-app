<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('private-chat.{id1}.{id2}', function ($user, $id1, $id2) {
  return (int) $user->id === (int) $id1 || (int) $user->id === (int) $id2;
});

Broadcast::channel('chat.{receiverId}', function ($user, $receiverId) {
  return (int) $user->id === (int) $receiverId;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
  return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
