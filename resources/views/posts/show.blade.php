@extends("layouts.main")

@section("title", "Post " . $post->id)

@section("custom-css")

    <link rel="stylesheet" href="{{ asset('css/posts.css')}}">

    <style>
        .comments-container {
            max-height: 400px; /* Adjust as needed */
            overflow-y: auto; /* Enable vertical scrolling */
            scrollbar-width: none; /* Hide scrollbar for Firefox */
        }

        .comments-container::-webkit-scrollbar {
            display: none; /* Hide scrollbar for Chrome, Safari, and Opera */
        }
        /* #comment_body {
            position:fixed;
            width:40%;
            top:450px;
            right:138px
        } */
        #postButton{
            /* position:fixed;
            bottom:201px;
            right:140px;
            font-weight:bold;
            z-index: 33; */
        }
        #comment_body:focus {
            outline: none;
            box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.5);
            border-radius: 0.5rem;    
        }
        #btn{
            position: absolute;
            right:50px;
            top:0px;
        }
    
    </style>
@endsection

@section("content")

@if ($post == '') 
    No post with this id
@else

<div class="container post-container">
    <!-- Button to go back to the index page -->
    <a id="btn" href="{{ route('posts.index') }}" class="btn btn-secondary h-9 py-2 mt-3">X</a>


    
    
            <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade post-images flex-column" data-bs-ride="carousel">
                <div class="carousel-item active">
                    <img width="510" height="510" src="{{ Storage::disk('public')->url($post->images[0]->img_path) }}" class="d-block w-100">
                </div>
                @foreach($post->images as $index => $image)
                    @if($loop->index == 0)
                        @continue
                    @endif
                    <div class="carousel-item">
                        <img  src="{{ Storage::disk('public')->url($image->img_path) }}" class="d-block w-100">
                    </div>
                @endforeach
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>  

    <div class="comments-container flex-column align-items-end" style="max-height: 400px; overflow-y: auto;">
        <div class="post-header">
            <img src="{{ asset('avatar/avatar.jpg') }}" alt="User Image">
            <a href="" class="text-dark text-decoration-none mb-3 text-lg">{{ $post->user->name }} </a>
        </div>

        <div class="post-caption text-dark">
            <p>{{ $post->caption }}</p>
        </div>

        <h6 id="commentsTitle" class="text-dark">Comments</h6>
        <div id="commentContainer">
        @foreach($post->comments->reverse() as $comment)

            <div class="comment">
                <div class="d-flex mb-3">
                    <img src="{{ asset('avatar/avatar.jpg') }}" alt="" class='w-10 rounded-circle'>
                    <a href="" class="text-dark text-decoration-none text-lg">{{ $post->user->name }}</a>
                </div>
                <div class="d-flex justify-content-between">
                    <div>
                        <p>{{ $comment->comment_body }}</p>
                        <small>{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <div>
                            <button class="btn btn-danger btn-sm comment-delete-button" data-comment-id="{{ $comment->id }}">Delete</button>
                    </div>
                </div>
            </div>

        @endforeach

        <div class="remaining-comments" style="display: none;">
            @foreach($post->comments->reverse()->slice(4) as $comment)
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
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm comment-delete-button" data-comment-id="{{ $comment->id }}">Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


        @if($post->comments->count() > 4)
            <button id="showMoreCommentsButton" class="btn btn-primary mt-3">Show More Comments</button>
        @endif
        <div class="comment-form mt-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="comment_body" id="comment_body" rows="1" placeholder="Add a comment..."></input>
                    <button data-post-id="{{ $post->id }}" id="postButton" class="bg-transparent text-primary mt-2">Post</button>
                </div>            
        </div>

    </div>
</div>

@endif

@endsection

@section("scripts")
<script type="module" src="{{ asset('js/posts.show.js') }}">
   
</script>
@endsection