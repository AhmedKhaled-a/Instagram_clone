@extends("layouts.main")


@section("title" , "Post " . $post->id)
@section("custom-css")
    <link rel="stylesheet" href="{{ asset("css/posts.css")}}">
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
