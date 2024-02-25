@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<style>
    .post {
        width: 40%;
        margin: auto;
        margin-bottom: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
    }

    .post-title {
        margin-bottom: 10px;
    }

    .post-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    .like-button {
        cursor: pointer;
    }

    .likes-count {
        margin-left: 5px;
    }

    .comment-form {
        margin-top: 20px;
    }

    .comment {
    background-color: #f0f0f0; 
    border-radius: 10px; 
    padding: 20px; 
    margin-top: 20px; 
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
}


    .comment {
        margin-bottom: 10px;
    }

    .comment-delete-button {
        margin-left: 5px;
    }
</style>
@endsection

@section("content")
<h1>Posts</h1>
<div class="row gap-3 justify-content-center align-items-center">
    @foreach ($posts as $post)
    <div id="{{ $post->id }}" class="post card">
        <h5 class="post-title card-title">
            <a class="link-dark" href="{{ route('posts.show' ,['id' => $post->id]) }}">{{ $post->caption }}</a>
        </h5>

        <div id="carouselExampleIndicators" class="carousel slide col-12 w-75 mx-auto" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach ($post->images as $index => $image)
        <div class="carousel-item @if ($index === 0) active @endif">
            <img class="d-block w-100 post-image" style="height: 200px;" src="{{ Storage::disk('public')->url($image->img_path) }}" alt="Post image">
        </div>
        @endforeach
    </div>
    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    @if(in_array($post->id, $likedPostsIDs))
                    <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-solid fa-heart like-button"></i>
                    @else
                    <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-regular fa-heart like-button"></i>
                    @endif
                </div>
                <div class="col-3">
                    <span class="likes-count">{{ $post->likes }}</span>
                </div>
                <div class="col-3">
                    <button id="{{ $post->id }}" onclick="deletePost(this)" class="btn btn-danger">Delete</button>
                </div>
            </div>

            {{-- Start Tags --}}
            @if ($post->tags->count() > 0)
            <div class="mb-2">
                @foreach ($post->tags as $tag)
                <span class="badge badge-light text-light bg-dark">{{ $tag->tag_text }}</span>
                @endforeach
            </div>
            @endif
            {{-- End Tags --}}

            <div class="comment-form">
                <form action="{{ route('comment.store', $post->id) }}" method="post">
                    @csrf
                    <textarea class="form-control" name="comment_body" rows="2" placeholder="Write a comment"></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Post comment</button>
                </form>
            </div>
        @foreach($post->comments as $comment)
        <div class="comment">
        <div class="d-flex mb-3">
           <img src="{{asset('imgs/p-5.jpg')}}" alt="" class='w-10 rounded-circle'>
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
        </div>
    </div>
    @endforeach
</div>
<div class="pagination">
    {{ $posts->links() }}
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
<script src="{{ asset('js/posts.index.js') }}"></script>
@endsection
