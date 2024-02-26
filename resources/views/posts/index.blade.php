@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<link rel="stylesheet" href="{{ asset("css/posts.css") }}">
<link rel="stylesheet" href="{{ asset("css/posts.css") }}">
@endsection

@section("content")
        <h1>Posts</h1>
        <div class="box my-5">
            <form method="get" action={{ route('posts.search') }}>
                <input type="text" class="input" name="search" onmouseout="this.value = ''; this.blur();">
            </form>
            <i class="fas fa-search"></i>
        </div>
        <div class="row w-100 justify-content-center align-items-center">
            @foreach ($posts as $post)
            <div id="{{ $post->id }}" class="post card col-8 justify-content-center">
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
        </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            @if($currentUser != null)
                                @if(in_array($post->id, $likedPostsIDs) )
                                <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-solid fa-heart like-button"></i>
                                @else
                                <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-regular fa-heart like-button"></i>
                                @endif
                            @endif
                        </div>
                        <div class="col-3">
                            <span class="likes-count likesCount-{{ $post->id }}">{{ $post->likes }}</span>
                        </div>

                        {{-- Post controls --}}
                        @if($currentUser != null)
                            @if( $currentUser->id == $post->user_id)
                                <div class="col-3">
                                    <button id="{{ $post->id }}" onclick="deletePost(this)" class="btn btn-sm btn-danger">Delete</button>
                                </div>
                                <div class="col-3">
                                    <a id="{{ $post->id }}" role="button" class="btn btn-sm btn-primary" href="{{ route('posts.update' ,['id' => $post->id]) }}">Update</a>
                                </div>
                            @endif
                        @endif
                        {{-- Post controls End --}}
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
                    @if($currentUser != null)
                                <div class="comment-form">
                                    <form action="{{ route('comment.store', $post->id) }}" method="post">
                                        @csrf
                                        <textarea class="form-control" name="comment_body" rows="2" placeholder="Write a comment"></textarea>
                                        <button type="submit" class="btn-sm btn btn-primary mt-2">Post comment</button>
                                    </form>
                                </div>
                    @endif
                @foreach($post->comments->reverse()->splice(0,3) as $comment)
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
                            @if($currentUser != null)
                                @if( $currentUser->id == $comment->user_id)
                                    <form method="POST" action="{{ route('comment.destroy' ,$comment->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm comment-delete-button">Delete</button>
                                    </form>
                                @endif
                            @endif

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
@endsection

@section('scripts')
<script src="{{ asset("js/posts.index.js") }}"></script>
@endsection
