
{{-- <p class="this-posts">{{ $posts }}</p> --}}
@foreach ($posts as $post)
<section id="{{ $post->id }}" class="my-4">
    <header>
      <img
        src="{{asset("avatar/avatar.jpg")}}"
        alt="profile image"
      />
      <div>
        <p>{{ $post->user->name }}</p>
        <i class="ri-verified-badge-fill my-auto"></i>
      </div>
    </header>

    <div class="card">
        <div class="visual carousel">
              @foreach ($post->images as $index => $image)
                  <img id="card{{$index + 1}}"  class="my-auto d-block w-100 h-100 post-image" src="{{ Storage::disk('public')->url($image->img_path) }}" alt="Post image">
              @endforeach
        </div>
    </div>

    <div class="social d-flex justify-content-between align-items-center">
      <div class="inter">
        <div>
          <button>
            <div>
                @if($currentUser != null)
                    @if(in_array( $post->id, $likedPostsIDs ) )
                        <i id="{{ $post->id }}" class="fa-solid fa-heart like-button mb-3 pd-5"></i>
                    @else
                        <i id="{{ $post->id }}" class="fa-regular fa-heart like-button mb-3 pd-5"></i>
                    @endif
                @endif
                <span class="likes-count likesCount-{{ $post->id }}">{{ $post->likes }} </span>
            </div>
          </button>
        @if($currentUser != null)
            @if(in_array( $post->id, $savedPostsIds ) )
              <i class="fa-solid fa-bookmark bookmark-btn mt-1"></i>
            @else
              <i class="fa-regular fa-bookmark bookmark-btn mt-1"></i>
            @endif  
        @endif

        @if ($post->tags->count() > 0)
          <div class="mb-2">
              @foreach ($post->tags as $tag)
                <a class="badge badge-dark text-light bg-secondary me-1 my-auto" href="{{ route('tags.show' ,['id' => $tag->id]) }}">{{ $tag->tag_text }}</a>
              @endforeach
          </div>
          @endif
        <p class="post-caption">{{ $post->caption }}</p>

        <div>
          @if($currentUser != null)
              @if($currentUser->id == $post->user_id)
                  <form method="POST" action="{{ route('posts.destroy' ,$post->id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm comment-delete-button">Delete</button>
                  </form>
              @endif
          @endif
        </div>

        <div>
          @if($currentUser != null)
              @if($currentUser->id == $post->user_id)
                  <form method="GET" action="{{ route('posts.edit' ,$post->id) }}">
                      <button type="submit" class="btn btn-primary btn-sm comment-update-button">Update</button>
                  </form>
              @endif
          @endif
        </div>
    </div>
    
</section>

@endforeach