@if ($receiver)
    <div class="chat-header">
        <div class="chat-header-info">
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
            <div>
                <h4>{{ $receiver->name }}</h4>
                <span class="status online"><i class="fas fa-circle"></i> Online</span>
            </div>
        </div>
        <div class="chat-header-actions">
            <i class="fas fa-phone-alt"></i>
            <i class="fas fa-video"></i>
            <i class="fas fa-ellipsis-v"></i>
        </div>
    </div>

    @include('chat._messages_list')

    @include('chat._message_input')
@else
    <div class="no-users-placeholder">
        <div class="placeholder-content">
            <i class="fas fa-users"></i>
            <h3>No other users yet</h3>
            <p>Share the registration link with friends to start chatting!</p>
        </div>
    </div>
@endif
