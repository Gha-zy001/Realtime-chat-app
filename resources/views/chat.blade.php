@extends('chat.layouts.app')

@section('content')
    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card chat-app">
                    @include('components.user-list', ['users' => $users])
                    @include('components.chat-box', [
                        'receiver' => $receiver,
                        // 'messages' => $messages,
                        'users' => $users,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
