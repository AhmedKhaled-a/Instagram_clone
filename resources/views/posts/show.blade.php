@extends("layouts.main")

@section("title", "Post " . $post->id)

@section("custom-css")
<link rel="stylesheet" href="{{ asset('css/posts.css')}}">
<style>
    /* Additional CSS for Instagram-like design */
    .post-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-top: 20px;
        display: flex; /* Use flexbox for layout */
    }

    .post-header {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .post-header img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .post-header h2 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
        color: #333; /* Darker text color for username */
    }

    .post-images {
        width: 50%; /* Set width to 50% */
        height: 100%; /* Set height to 100% */
        position: relative; /* Position the user info relative to this container */
    }

    .post-images .carousel-inner .carousel-item img {
        border-radius: 10px;
        height: 100%; /* Make images fill the height */
    }

    .post-caption {
        font-size: 16px;
        margin-bottom: 10px;
        color: #333; /* Darker text color for caption */
    }

    .tag {
        margin-right: 5px;
        font-size: 14px;
        color: #3897f0; /* Tag text color */
        background-color: #f0f0f0; /* Background color for hashtags */
        padding: 3px 8px;
        border-radius: 5px;
    }

    .comments-container {

        width: 50%; /* Set width to 50% */
        padding-left: 20px; /* Add some left padding for spacing */
        position: relative;
        
        top:70%;/* Position the user info relative to this container */
    }

    .comment {
        border-bottom: 1px solid #ddd;
        padding-bottom: 15px;
        margin-bottom: 15px;
        color: #333; /* Darker text color for comments */
    }

    .comment img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .comment p {
        margin: 0;
        font-size: 16px; 
    }

    .comment small {
        font-size: 12px;
        color: #999; 
    }

    .comment-form {
        margin-top: 30px;
    }

    .comment-form textarea {
        width: calc(100% - 20px); 
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 10px;
        resize: none;
    }

    .comment-form button {
        margin-top: 10px;
        padding: 8px 20px;
        background-color: #3897f0;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .user-info {
        position: absolute;
        top: 0; 
        left: 20px;
        display: flex;
        align-items: center;
        padding: 10px;
        border-radius: 5px;
    }

    .user-info img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }
</style>
@endsection

@section("content")

@if ($post == '') 
No post with this id
@else

<div class="container post-container">
    <div class="post-images">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($post->images as $index=>$image)
                <div class="carousel-item @if($index === 0) active @endif">
                    <img src="{{Storage::disk('public')->url($image->img_path) }}" class="d-block w-100" alt="Post image">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="comments-container">
        <div class="post-header">
            <img src="{{asset('imgs/p-5.jpg')}}" alt="User Image">
            <a href="" class="text-dark text-decoration-none mb-3 text-lg">{{ $post->user->name }} </a>
        </div>

        <div class="post-caption">
            <p>{{$post->caption }}</p>
        </div>

        <h3>Comments</h3>
        @foreach($post->comments as $comment)
        <div class="comment">
        <div class="d-flex mb-3">
           <img src="{{asset('imgs/p-5.jpg')}}" alt="" class='w-10 rounded-circle'>
           <a href="" class="text-dark text-decoration-none text-lg">{{ $post->user->name }} </a>
          </div>
          <div class="d-flex justify-content-between">
          <div>
              <p>{{$comment->comment_body }}</p>
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
                <textarea name="comment_body" rows="3" placeholder="Add a comment..."></textarea>
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
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@parent
@endsection
