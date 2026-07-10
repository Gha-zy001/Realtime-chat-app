@extends('layouts.chat')

@section('title', 'Chat App')

@section('content')
    @include('chat._sidebar')

    <div class="main-chat">
        @include('chat._chat_area')
    </div>
@endsection

@push('scripts')
<script>
    Pusher.logToConsole = true;

    const currentReceiverId = '{{ $receiver ? $receiver->id : null }}';
    const currentUserId = '{{ $authUser->id }}';

    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: 'eu'
    });

    pusher.connection.bind('connected', function() {
        console.log('Pusher connected successfully');
    });

    function updateSidebar(userId, userName, message) {
        const item = $(`.user-item[data-user-id="${userId}"]`);
        if (!item.length) return;

        item.find('.last-msg').text(message);
        item.closest('.user-list-wrapper').prepend(item);

        if (currentReceiverId != userId) {
            item.addClass('has-new');
        }
    }

    $(document).on('click', '.user-item', function() {
        $('.user-item').removeClass('has-new');
    });

    const channel = pusher.subscribe('public');
    channel.bind('chat', function(data) {
        console.log('Pusher event received:', data);
        updateSidebar(data.user.id, data.user.name, data.message);

        if (currentReceiverId && data.user.id == currentReceiverId) {
            $.post("{{ route('receive') }}", {
                    _token: '{{ csrf_token() }}',
                    message: data.message,
                    user: data.user
                })
                .done(function(res) {
                    $(".messages-area").append(res);
                    scrollToBottom();
                });
        }
    });

    function scrollToBottom() {
        const area = document.getElementById('messagesArea');
        if (area) {
            area.scrollTop = area.scrollHeight;
        }
    }

    $("#messageForm").submit(function(event) {
        event.preventDefault();

        const input = $("#message");
        const message = input.val().trim();
        if (!message) return;

        $.ajax({
            url: "{{ route('broadcast') }}",
            method: 'POST',
            headers: {
                'X-Socket-Id': pusher.connection.socket_id
            },
            data: {
                _token: '{{ csrf_token() }}',
                message: message,
                receiver_id: '{{ $receiver ? $receiver->id : 0 }}',
                user: {
                    id: '{{ $authUser->id }}',
                    name: '{{ $authUser->name }}',
                }
            }
        }).done(function(res) {
            console.log('Message sent successfully');
            updateSidebar('{{ $authUser->id }}', '{{ $authUser->name }}', message);
            $(".messages-area").append(res);
            input.val('');
            scrollToBottom();
        }).fail(function(xhr) {
            console.error('Send failed:', xhr.responseText);
        });
    });

    $("#searchUser").on("keyup", function() {
        const value = this.value.toLowerCase();
        $(".user-item").each(function() {
            $(this).toggle($(this).data("name").toLowerCase().includes(value));
        });
    });

    scrollToBottom();
</script>
@endpush
