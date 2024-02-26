@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<link rel="stylesheet" href="{{ asset("css/posts.css") }}">
<link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"/>
@endsection

@section("content")

<h1>Posts</h1>
<div class="box my-5">
    <form method="get" action={{ route('posts.search') }}>
        @csrf
        <input type="text" class="input" name="search" onmouseout="this.value = ''; this.blur();">
    </form>
    <i class="fas fa-search"></i>
</div>

@foreach ($posts as $post)
<section class="my-4">
    <header>
      <img
        src="{{asset("avatar/avatar.jpg")}}"
        alt="profile image"
      />
      <div>
        <p>@if($currentUser) {{$currentUser->name}} @endif</p>
        <i class="ri-verified-badge-fill"></i>
      </div>
    </header>
    
    <div class="card">
      <div id="carousel" class="visual">
            @foreach ($post->images as $index => $image)
                <img id="card{{$index + 1}}"  class="my-auto d-block w-100 h-100 post-image" src="{{ Storage::disk('public')->url($image->img_path) }}" alt="Post image">
            @endforeach
        </div>

        <div class="controls">
            <button
                id="prev"
                class="previous"
                onclick="carousel.scrollBy(-100, 0)">
                <i class="ri-arrow-left-circle-fill"></i>
            </button>

            <button id="next" class="next" onclick="carousel.scrollBy(100, 0)">
                <i class="ri-arrow-right-circle-fill"></i>
            </button>
        </div>
    </div>
    <div class="social">
      <div class="inter">
        <div>
          <button>
            <div>
                @if($currentUser != null)
                    @if(in_array($post->id, $likedPostsIDs) )
                        <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-solid fa-heart like-button"></i>
                    @else
                        <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-regular fa-heart like-button"></i>
                    @endif
                @endif
            </div>
          </button>
          @if ($post->tags->count() > 0)
          <div class="mb-2">
              @foreach ($post->tags as $tag)
                <a class="badge badge-dark text-light bg-secondary" href="{{ route('tags.show' ,['id' => $tag->id]) }}">{{ $tag->tag_text }}</a>
              @endforeach
          </div>
          @endif
        @if($currentUser != null)  
            <button>
                <i class="ri-bookmark-line"></i>
            </button>
        @endif
    </div>
    <p><span class="likes-count likesCount-{{ $post->id }}">{{ $post->likes }} </span> likes</p>
    <p>{{ $post->caption }}</p>
</section>
@endforeach

<div class="row justify-content-center align-items-center w-75 my-auto">
    {!! $posts->links() !!}
</div>
@endsection

@section('scripts')
<script src="{{ asset("js/posts.index.js") }}"></script>

<script src="{{ asset("js/postsCarousel.js") }}"></script>
@endsection
