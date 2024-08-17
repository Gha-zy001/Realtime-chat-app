<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="chat">
  <div class="chat-header clearfix">
    <div class="row">
      <div class="col-lg-6">
        <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
          <img src="{{ $receiver->avatar }}" alt="avatar">
        </a>
        <div class="chat-about">
          <h6 class="m-b-0">{{ $receiver->name }}</h6>
          <small>Last seen: {{ $receiver->last_seen }}</small>
        </div>
      </div>
      <div class="col-lg-6 hidden-sm text-right">
        <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
        <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image"></i></a>
        <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
        <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
      </div>
    </div>
  </div>
  <div class="chat-history">
    <ul class="m-b-0" id="messageList">
      <!-- Messages will be appended here by JavaScript -->
    </ul>
  </div>
  <div class="chat-message clearfix">
    <div class="input-group mb-0">
      <input type="text" id="message" class="form-control" placeholder="Enter text here...">
      <div class="input-group-append">
        <button id="send" class="btn btn-primary" type="button">
          <i class="fa fa-send"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Initialize Pusher
    Pusher.logToConsole = true;

    var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        encrypted: true
    });

    var channel = pusher.subscribe('chat{{ $receiver->id }}');
    channel.bind('ChatSent', function(data) { // Make sure the event name matches
        console.log("Received message via Pusher: ", data);
        let message = `<li class="clearfix">
                         <div class="message-data text-right">
                             <span class="message-data-time">${new Date(data.timestamp).toLocaleTimeString()}</span>
                             <img src="{{ $receiver->avatar }}" alt="avatar">
                         </div>
                         <div class="message other-message float-right"> ${data.message} </div>
                     </li>`;
        $(".chat-history ul").append(message);
        $(".chat-history").scrollTop($(".chat-history")[0].scrollHeight); // Scroll to the bottom
    });

    function sendMessage() {
        let message = $('#message').val();
        if (message.trim() === '') return;

        $.post(`/chat/{{ $receiver->id }}`, {
            _token: '{{ csrf_token() }}',
            message: message,
        }).done(function(data) {
            console.log("Server response: ", data);
            let senderMessage = `<li class="clearfix">
                                   <div class="message-data">
                                       <span class="message-data-time">${new Date().toLocaleTimeString()}</span>
                                   </div>
                                   <div class="message my-message"> ${message} </div>
                               </li>`;
            $(".chat-history ul").append(senderMessage);
            $('#message').val('');
            $(".chat-history").scrollTop($(".chat-history")[0].scrollHeight);
        }).fail(function(xhr, status, error) {
            console.log("Error: ", error);
        });
    }

    $('#send').click(function() {
        sendMessage();
    });

    $('#message').keypress(function(e) {
        if (e.which == 13) { // Enter key code
            e.preventDefault();
            sendMessage();
        }
    });
});

</script>
