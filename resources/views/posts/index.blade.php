@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<link rel="stylesheet" href="{{ asset("css/posts.css") }}">
@endsection

@section("content")
        <h1>Posts</h1>
        <div class="row gap-3 justify-content-center align-items-center">
            @foreach ($posts as $post)
            <div id="{{ $post->id }}" class="post card col-6 justify-content-center">
                <h5 class="post-title card-title">
                    <a class="link-dark" href="{{ route('posts.show' ,['id' => $post->id]) }}">{{ $post->caption }}</a>
                </h5>
        
                <div id="carouselExampleIndicators" class="carousel slide col-12 w-75 mx-auto" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($post->images as $index => $image)
                <div class="carousel-item @if ($index === 0) active @endif">
                    <img class="my-auto d-block w-75 post-image" style="height: 200px;" src="{{ Storage::disk('public')->url($image->img_path) }}" alt="Post image">
                </div>
                @endforeach
            </div>
            {{-- <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> --}}
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
                        <a class="badge badge-light text-light bg-dark" href="{{ route('tags.show' ,['id' => $tag->id]) }}">{{ $tag->tag_text }}</a>
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
                <div class="row justify-content-center align-items-center w-75 my-auto">
                {!! $posts->links() !!}
                </div>
            </div>
            <form action="{{ route('comment.store', $post->id) }}" method="post">
                @csrf
                <div class='mb-3'>
                   <textarea class="fs-6 form-control" name="comment_body" cols="100" rows="2"></textarea> 
                </div>
                <div>
                    <button type="submit" class="btn btn-primary btn-sm">Post comment</button>
                </div>
            </form>
            @foreach($post->comments as $comment )
            <a href="">{{$post->user->name}}</a>
            <p>
                {{$comment->comment_body}}
                ({{$comment->created_at}})

                <form method="POST" action="{{ route('comment.destroy' ,$comment->id)}}">
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                <hr>
            </p>
        @endforeach
        <meta name="csrf-token" content="{{ csrf_token() }}">

@section('scripts')
<script src="{{ asset('js/posts.index.js') }}"></script>
@endsection
