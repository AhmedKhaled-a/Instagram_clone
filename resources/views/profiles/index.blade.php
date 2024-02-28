@extends('layout.app')

@section('title')
    <title>{{ $user->name }}</title>
@endsection

@section('content')
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show w-25 mx-auto" role="alert">
        <strong>Success,</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-4 d-flex align-items-start justify-content-center">
                <img src="{{ $user->getAvatarUrl() }}" class=" w-50 rounded-circle">
            </div>
            <div class="col-8">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-start pb-2">
                        <h3 class="font-weight-light mr-3">{{ $user->name }}</h3>
                        @if (Auth::check() && Auth::id() != $user->id)
                            {{-- Block Button --}}
                            @if (Auth::user()->isBlocking($user))
                                <form action="{{ route('users.unblock', $user) }}" method="POST" class=" d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-dark">unblock</button>
                                </form>
                            @endif

                            @if (Auth::user()->follows($user))
                                <form method="POST" action="{{ route('user.unfollow', $user->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Unfollow</button>
                                </form>
                            @elseif (!Auth::user()->isBlocking($user))
                                <form method="POST" action="{{ route('user.follow', $user->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        @if (auth()->user()->followers->contains($user))
                                            Follow back
                                        @else
                                            Follow
                                        @endif
                                    </button>
                                </form>
                                {{-- @if (session()->has('follow success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('follow success') }}
                                    </div>
                                @endif --}}
                            @endif
                        @else
                            @auth
                                <a href="{{ route('profile.edit') }}" class="btn btn-success">Edit Profile</a>
                            @endauth
                        @endif
                    </div>
                    @can('update', $user->profile)
                        <a href="/p/create">Add New Post</a>
                    @endcan
                </div>

                {{-- @if (Auth::check() && Auth::id() == $user->id)
                    <a href="{{ route('profile.edit') }}" class="btn btn-success">Edit Profile</a>
                @endif --}}

                <div class="d-flex pt-4">
                    <div class="pr-5"><strong>3</strong> posts</div>
                    <div class="followers pr-5"><strong>{{ $user->followers->count() }}</strong> followers</div>
                    <div class="followings pr-5"><strong>{{ $user->following->count() }}</strong> following</div>
                    @if (Auth::id() == $user->id)
                        <div class="blocked pr-5"><strong>{{ $user->blockedUsers->count() }}</strong> Blocked users</div>
                    @endif
                    {{-- Followers --}}
                    <div class="followers-container d-none text-white">
                        <div class="followers-list w-25">
                            <h2 class="text-center my-3">Followers</h2>
                            <hr style="background-color: #5d6062">
                            @foreach ($user->followers as $follower)
                                <div class="d-flex justify-content-between align-items-center">
                                    <a
                                        href="{{ route('profile.index', ['user' => $follower->id]) }}">{{ $follower->name }}</a>
                                    @auth
                                        @if (Auth::id() == $user->id)
                                            {{-- Block Button --}}
                                            @if (Auth::user()->isBlocking($user))
                                                <form action="{{ route('users.unblock', $follower) }}" method="POST"
                                                    class=" d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">unblock</button>
                                                </form>
                                            @else
                                                <form action="{{ route('users.block', $follower) }}" method="POST"
                                                    class=" d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">Block</button>
                                                </form>
                                            @endif
                                            {{-- End Block Button --}}
                                        @endif
                                    @endauth
                                </div>
                                <hr class="bg-light">
                            @endforeach
                        </div>
                    </div>
                    {{-- Followings --}}
                    <div class="followings-container d-none text-white">
                        <div class="followings-list w-25">
                            <h2 class="text-center my-3">Followings</h2>
                            <hr style="background-color: #5d6062">
                            @foreach ($user->following as $followedUser)
                                <div class="d-flex justify-content-between align-items-center">
                                    <a
                                        href="{{ route('profile.index', ['user' => $followedUser->id]) }}">{{ $followedUser->name }}</a>
                                    @auth
                                        @if (Auth::id() == $user->id)
                                            {{-- Block Button --}}
                                            @if (Auth::user()->isBlocking($user))
                                                <form action="{{ route('users.unblock', $followedUser) }}" method="POST"
                                                    class=" d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">unblock</button>
                                                </form>
                                            @else
                                                <form action="{{ route('users.block', $followedUser) }}" method="POST"
                                                    class=" d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">Block</button>
                                                </form>
                                            @endif
                                            {{-- End Block Button --}}
                                        @endif
                                    @endauth
                                </div>
                                <hr class="bg-light">
                            @endforeach
                        </div>
                    </div>

                    {{-- Blocked --}}
                    <div class="blocked-container d-none text-white">
                        <div class="blocked-list w-25">
                            <h2 class="text-center my-3">Blocked Users</h2>
                            <hr style="background-color: #5d6062">
                            @foreach ($user->blockedUsers as $blockedUser)
                                <div class="d-flex justify-content-between align-items-center">
                                    <a
                                        href="{{ route('profile.index', ['user' => $blockedUser->id]) }}">{{ $blockedUser->name }}</a>
                                    @auth
                                        @if (Auth::id() == $user->id)
                                            {{-- Block Button --}}
                                            @if (Auth::user()->isBlocking($blockedUser))
                                                <form action="{{ route('users.unblock', $blockedUser) }}" method="POST"
                                                    class=" d-inline-block">
                                                    @csrf
                                                    <button type="submit" class="btn btn-dark">unblock</button>
                                                </form>
                                            @endif
                                            {{-- End Block Button --}}
                                        @endif
                                    @endauth
                                </div>
                                <hr class="bg-light">
                            @endforeach
                        </div>
                    </div>
                    {{-- End Blocked Users --}}
                </div>
                <div class="pt-3">
                    <strong>{{ $user->name }}</strong>
                    <span
                        class="badge {{ $user->gender == 'male' ? 'text-bg-primary' : 'text-bg-danger' }}">{{ $user->gender }}
                    </span>
                </div>

                <div class="mt-2">{{ $user->bio }}</div>

                <div class="mt-3">
                    <a class="icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;"
                        href="{{ $user->website }}">
                        {{ $user->website }}
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h3 class="text-center mt-5 col-11 d-inline-block">posts</h3>
            <a href="" title="saved posts"
                class="col-1 link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><img
                    src="{{ asset('imgs/icons/save-icon.png') }}" alt="save icon" style="width:30px;">Saved</a>
            <hr class="mb-0">
        </div>
        <div class="row pt-5">
            @if (Auth::check() && Auth::user()->isBlocking($user))
                <div class="card w-75 mb-3 text-center mx-auto bg-secondary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Can't Access</h5>
                        <p class="card-text">Unblock the user to see his posts</p>
                    </div>
                </div>
            @else
                <div class="col-4 pb-4">
                    <a href="/posts/">
                        <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            class="w-100">
                    </a>
                </div>

                <div class="col-4 pb-4">
                    <a href="/posts/">
                        <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            class="w-100">
                    </a>
                </div>

                <div class="col-4 pb-4">
                    <a href="/posts/">
                        <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            class="w-100">
                    </a>
                </div>

                <div class="col-4 pb-4">
                    <a href="/posts/">
                        <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                            class="w-100">
                    </a>
                </div>
        </div>
        @endif
        {{-- @foreach ($user->posts as $post)
        <div class="col-4 pb-4">
            <a href="/p/{{ $post->id }}">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </a>
        </div>
        @endforeach --}}
    </div>
@endsection
