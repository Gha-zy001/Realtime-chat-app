<div class="messages-area" id="messagesArea">
    @foreach ($messages as $msg)
        @if ($msg->sender == Auth::id())
            @include('chat.partials.broadcast', ['message' => $msg->message])
        @else
            @include('chat.partials.receive', ['message' => $msg->message, 'user' => ['name' => $receiver->name]])
        @endif
    @endforeach
</div>
