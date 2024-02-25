@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<link rel="stylesheet" href="{{ asset("css/posts.css") }}">
@endsection

@section("content")
        <h1>Posts</h1>
            <div class="row gap-3 justify-content-center align-items-center">
                @foreach ($posts as $post)
                <div id="{{ $post->id }}" class="post card col-4" style="width:33%; my-auto; height:40vw">
                    <h5 class="card-title">
                        <a class="link-dark link-opacity-100-hover link-opacity-50 link-offset-3-hover link-underline  link-underline-opacity-0 link-underline-opacity-100-hover" href="{{ route("posts.show" ,["id" => $post->id]) }}">{{ $post->caption }}</a>
                    </h5>
                    @if(count($post->images) > 0)
                        <img class="card-img-top" src="{{ Storage::disk('public')->url($post->images[0]->img_path) }}" alt="Card image cap">
                    @else
                        <img class="card-img-top" src="{{ Storage::disk('public')->url("posts/8ENpYSGJZ88eJWKMkz5lQNswtSs5QdaRWCOd1M6Y.jpg") }}" alt="Card image cap">
                    @endif
                    <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            @if(in_array($post->id, $likedPostsIDs))
                                <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-solid fa-heart"></i>
                            @else
                                <i onclick="toggleLike(this)" id="{{ $post->id }}" class="fa-regular fa-heart"></i>
                            @endif
                        </div>
                        <div class="col-3">
                            <p class="likesCount-{{ $post->id }}">{{ $post->likes }}</p>
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
                            <img src="{{asset('avatar/p-5.jpg')}}" alt="" class='w-10 rounded-circle'>
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
                <div class="row justify-content-center align-items-center w-75 my-auto">
                {!! $posts->links() !!}
                </div>
            </div>
@endsection

@section('scripts')
<script src="{{ asset("js/posts.index.js") }}"></script>
@endsection
