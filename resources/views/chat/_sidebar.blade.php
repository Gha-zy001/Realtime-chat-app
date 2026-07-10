<div class="sidebar">
    <div class="sidebar-header">
        <div class="app-brand">
            <i class="fas fa-comments"></i>
            <span>ChatApp</span>
        </div>
        <div class="user-info">
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="avatar">
            <span class="username">{{ $authUser->name }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
    <div class="sidebar-search">
        <i class="fas fa-search search-icon"></i>
        <input type="text" id="searchUser" placeholder="Search users..." class="search-input">
    </div>
    <div class="user-list-wrapper">
        @include('components.user-list', ['users' => $users])
    </div>
</div>
