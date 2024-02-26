@foreach ($posts as $post)

<section class="my-4">
    <h2 class="d-none" id="userId" userId="{{ $currentUser->id }}"></h2>
    <header>
      <img
        src="{{asset("avatar/avatar.jpg")}}"
        alt="profile image"
      />
      <div>
        <p>{{ $post->user->name }}</p>
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
                    @if(in_array( $post->id, $likedPostsIDs ) )
                        <i id="{{ $post->id }}" class="fa-solid fa-heart like-button"></i>
                    @else
                        <i id="{{ $post->id }}" class="fa-regular fa-heart like-button"></i>
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