@foreach ($users as $user)
    <a href="{{ route('chat.user', ['user' => $user->id]) }}" class="user-item {{ isset($receiver) && $receiver->id == $user->id ? 'active' : '' }}" data-user-id="{{ $user->id }}" data-name="{{ $user->name }}">
        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar" class="user-avatar">
        <div class="user-meta">
            <div class="user-name">{{ $user->name }}</div>
            <div class="user-preview">
                <span class="last-msg">{{ $user->name }} joined the chat</span>
            </div>
        </div>
        <div class="user-status">
            <span class="online-dot {{ $user['online'] ?? false ? 'online' : 'offline' }}"></span>
        </div>
    </a>
@endforeach
