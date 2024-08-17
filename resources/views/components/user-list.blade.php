<link rel="stylesheet" href="{{asset('style.css')}}">
<div id="plist" class="people-list">
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-search"></i></span>
        </div>
        <input type="text" class="form-control" placeholder="Search...">
    </div>
    <ul class="list-unstyled chat-list mt-2 mb-0">
        @foreach ($users as $user)
            <li class="clearfix {{ $loop->first ? 'active' : '' }}">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
                <div class="about">
                    <div class="name">
                        <a href="{{ route('chat.user', ['user' => $user->id]) }}">
                            {{ $user->name }}
                        </a>
                    </div>
                    <div class="status">
                        <i class="fa fa-circle {{ $user['online'] ? 'online' : 'offline' }}"></i>
                        {{-- {{ $user['status'] }} --}}
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
