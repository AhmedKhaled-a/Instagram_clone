@extends('layout.app')
@section('title')
    <title>Users</title>
@endsection
@section('content')
    <div class="container w-50 mx-auto">
        <form action="{{ route('user.index') }}" method="GET" class="my-5">
            <input class="form-control" type="text" name="search" placeholder="Search users" value="{{ $search }}">
        </form>
        
        @if (count($users))
            <ul class="list-unstyled">
                @foreach ($users as $user)
                    <li class="user">
                        <a href="{{ route('profile.index', ['user' => $user->id]) }}">
                            <img class="rounded-circle me-2" width="40" src="{{ $user->getAvatarUrl() }}" alt="">
                            {{ $user->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
