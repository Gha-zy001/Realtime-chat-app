<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="{{ asset('chat/style.css') }}">
</head>

<body>
    <div class="container">

        <div class="row">
            <!-- User List -->
            <div class="col-md-4">
                @include('components.user-list', ['users' => $users])
            </div>
            <div class="col-md-8">
                <div class="chat">
                    <div class="top">
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                        <div>
                            <p>{{ $receiver->name }}</p>
                            <small>Online</small>
                        </div>
                    </div>
                    <div class="messages">
                        @include('chat.layouts.receive', ['message' => 'Hey!'])
                    </div>
                    <div class="bottom">
                        <form action="">
                            <input type="text" id="message" name="message" placeholder="Enter Message..">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</body>
<script>
  const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
      cluster: 'eu'
  });
  const channel = pusher.subscribe('public');
  channel.bind('chat', function(data) {
      $.post("/receive", {
              _token: '{{ csrf_token() }}',
              message: data.message,
              user: data.user
          })
          .done(function(res) {
              $(".messages > .message").last().after(res);
              $(document).scrollTop($(document).height());
          });
  });
  $("form").submit(function(event) {
      event.preventDefault();

      $.ajax({
          url: "/broadcast",
          method: 'POST',
          headers: {
              'X-Socket-Id': pusher.connection.socket_id
          },
          data: {
              _token: '{{ csrf_token() }}',
              message: $("form #message").val(),
              user: {
                  name: '{{ $authUser->name }}',

              }
          }
      }).done(function(res) {
          $(".messages > .message").last().after(res);
          $("form #message").val('');
          $(document).scrollTop($(document).height());
      });
  });
</script>
</html>
