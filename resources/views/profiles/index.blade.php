@extends('layout.app')

@section('title')
<title>{{ $user->name }}</title>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 d-flex align-items-start justify-content-center">
            <img src="https://th.bing.com/th/id/R.c68f81082d59285a4b2fae43f7778772?rik=tVn5GUk8crzqaA&riu=http%3a%2f%2fwww.pngall.com%2fwp-content%2fuploads%2f5%2fUser-Profile-PNG-Clipart.png&ehk=XjMZT9I1logRUJAs%2bo2aZelxooUclPwYXWlh3%2b7V9g0%3d&risl=&pid=ImgRaw&r=0" class="rounded-circle w-50" style="border: 1px solid #e4e3e1">
        </div>
        <div class="col-8">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-start pb-2">
                    <h3 class="font-weight-light mr-3">{{ $user->name }}</h3>
                    @if ((Auth::check()) && (Auth::id() != $user->id))
                    <button user_id='{{ Auth::id() }}' follows='{{ $user->id }}' class="btn btn-primary">Follow</button>
                    {{-- <follow-button user-id="1" follows="23">Follow</follow-button> --}}
                    @endif
                </div>
                @can('update', $user->profile)
                <a href="/p/create">Add New Post</a>
                @endcan
            </div>

            @if ((Auth::check()) && (Auth::id() == $user->id))
            <a href="{{ route('profile.edit') }}">Edit Profile</a>
            @endif

            <div class="d-flex pt-4">
                <div class="pr-5"><strong>3</strong> posts</div>
                <div class="pr-5"><strong>165</strong> followers</div>
                <div class="pr-5"><strong>176</strong> following</div>
            </div>
            <div class="pt-3"><strong>{{ $user->name }}</strong></div>
            <div>This place i can feel its pain...</div>
            <div><a href="#">www.mahmouddwidar.com</a></div>
        </div>
    </div>

    <div class="col-12">
        <h3 class="text-center mt-5 col-11 d-inline-block">posts</h3>
        <a href="" title="saved posts" class="col-1"><img src="{{ asset('imgs/icons/save-icon.png') }}" alt="save icon" style="width:30px;"></a>
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
