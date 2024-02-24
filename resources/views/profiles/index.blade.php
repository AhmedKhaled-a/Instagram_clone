@extends('layout.app')

@section('title')
<title>{{ $user->name }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 d-flex align-items-start justify-content-center">
            <img src="{{ $user->getAvatarUrl() }}" class="rounded-circle w-50" style="border: 1px solid #e4e3e1">
        </div>
        <div class="col-8">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-start pb-2">
                    <h3 class="font-weight-light me-4">{{ $user->name }}</h3>
                    @auth
                        @if (Auth::id() != $user->id)
                            <button user_id='{{ Auth::id() }}' follows='{{ $user->id }}' class="btn btn-primary">Follow</button>
                        @else
                            <a href="{{ route('profile.edit') }}" class="btn btn-success">Edit Profile</a>
                        @endif
                    @endauth
                    {{-- @if ((Auth::check()) && (Auth::id() != $user->id))
                    <button user_id='{{ Auth::id() }}' follows='{{ $user->id }}' class="btn btn-primary">Follow</button>
                    <follow-button user-id="1" follows="23">Follow</follow-button>
                    @else
                    <a href="{{ route('profile.edit') }}" class="btn btn-success">Edit Profile</a>
                    @endif --}}
                </div>
                {{-- @can('update', $user->profile)
                <a href="/p/create">Add New Post</a>
                @endcan --}}
            </div>

            <div class="d-flex pt-4">
                <div class="pe-5"><strong>3</strong> posts</div>
                <div class="pe-5"><strong>165</strong> followers</div>
                <div class="pe-5"><strong>176</strong> following</div>
            </div>
            <div class="pt-3">
                <strong>{{ $user->name }}</strong>
                <span class="badge {{ ($user->gender == 'male') ? 'text-bg-primary' : 'text-bg-danger' }}">{{ $user->gender }} </span>
            </div>

            <div class="mt-2">{{ $user->bio }}</div>

            <div class="mt-3">
                <a class="icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;" href="{{ $user->website }}">
                    {{ $user->website }}
                    <svg class="bi" aria-hidden="true"><use xlink:href="#arrow-right"></use></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="col-12">
        <h3 class="text-center mt-5 col-11 d-inline-block">posts</h3>
        <a href="" title="saved posts" class="col-1 link-dark link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"><img src="{{ asset('imgs/icons/save-icon.png') }}" alt="save icon" style="width:30px;">Saved</a>
        <hr class="mb-0">
    </div>
    <div class="row pt-5">
        {{-- @foreach($user->posts as $post)
        <div class="col-4 pb-4">
            <a href="/p/{{ $post->id }}">
                <img src="/storage/{{ $post->image }}" class="w-100">
            </a>
        </div>
        @endforeach --}}

        <div class="col-4 pb-4">
            <a href="/posts/">
                <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="w-100">
            </a>
        </div>
        <div class="col-4 pb-4">
            <a href="/posts/">
                <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="w-100">
            </a>
        </div>
        <div class="col-4 pb-4">
            <a href="/posts/">
                <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="w-100">
            </a>
        </div>
        <div class="col-4 pb-4">
            <a href="/posts/">
                <img src="https://images.pexels.com/photos/248533/pexels-photo-248533.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="w-100">
            </a>
        </div>
    </div>
</div>
@endsection
