@extends("layouts.main")


@section("title" , "Post " . $post->id)
@section("custom-css")
    <link rel="stylesheet" href="{{ asset('css/posts.css')}}">
@endsection

@section("content")

@if ($post == '') 
No post with this id
@else

<div class="container post-container">
    <div class="post-images">
        <div id="carouselExampleIndicators" class="carousel slide " data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($post->images as $index => $image)
                <div class="carousel-item @if($index === 0) active @endif">
                    <img src="{{ Storage::disk('public')->url($image->img_path) }}" class="d-block w-100" alt="Post image">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="comments-container">
        <div class="post-header">
            <img src="{{ asset('avatar/avatar.jpg') }}" alt="User Image">
            <a href="" class="text-dark text-decoration-none mb-3 text-lg">{{ $post->user->name }} </a>
        </div>

        <div class="post-caption">
            <p>{{ $post->caption }}</p>
        </div>

        <h3>Comments</h3>
        @foreach($post->comments as $comment)
        <div class="comment">
        <div class="d-flex mb-3">
           <img src="{{ asset('avatar/avatar.jpg') }}" alt="" class='w-10 rounded-circle'>
           <a href="" class="text-dark text-decoration-none text-lg">{{ $post->user->name }} </a>
          </div>
          <div class="d-flex justify-content-between">
          <div>
              <p>{{ $comment->comment_body }}</p>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div>
            <form method="POST" action="{{ route('comment.destroy' ,$comment->id) }}">
              @csrf
            @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm comment-delete-button">Delete</button>
            </form>
            </div>
            </div>
        </div>
        @endforeach

        <div class="comment-form">
            <form action="{{ route('comment.store', $post->id) }}" method="post">
                @csrf
                <textarea class="text-dark" name="comment_body" rows="3" placeholder="Add a comment..."></textarea>
                <button type="submit">Post</button>
            </form>
        </div>
    </div>
</div>

@endif

@endsection

@section("scripts")
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
@parent

@endsection

@extends("layouts.main")


@section("title" , "Post " . $post->id)
@section("custom-css")
    <link rel="stylesheet" href="{{ asset('css/posts.css')}}">
@endsection

@section("content")

@if ($post == '') 
    No post with this id
@else

<div class="p-5 container row justify-content-center align-items-center">
    {{-- <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="..." class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="..." class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div> --}}

      
    {{-- Slider --}}
    <div id="carouselExampleIndicators" class="carousel slide col-12  w-75" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true"></button>
            @for($i = 1; $i < sizeof($post->images); $i++)
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $i }}" aria-label="Slide 3"></button>
            @endfor
        </div>      

        <div class="carousel-inner">
            <div class="carousel-item active w-100">
                <img class="d-block w-100" style="height: 32em" src="{{ Storage::disk('public')->url($post->images[0]->img_path) }}" alt="Post image">
            </div>
            @foreach( $post->images as $image)
                @if ($loop->first) @continue @endif
                <div class="carousel-item w-100">
                    <img class="d-block w-100" style="height: 32em" src="{{ Storage::disk('public')->url($image->img_path) }}" alt="Post image">
                </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
    {{-- End Slider --}}

    <p>{{ $post->caption }}</p>    
    {{-- Start Tags --}}
    @if ($post->tags->count() > 0)
    <div class="mb-2">
        <strong>Tags:</strong>
        @foreach ($post->tags as $tag)
        <span class="badge badge-light text-light bg-dark">{{ $tag->tag_text }}</span>
        @endforeach
    </div>
    @endif
    {{-- End Tags --}}
@endif

@endsection

@section("scripts")
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@parent

@endsection