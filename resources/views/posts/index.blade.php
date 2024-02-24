@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")

@endsection

@section("content")
        <h1>Posts</h1>
            <div class="row gap-3 justify-content-center align-items-center">
                @foreach ($posts as $post)
                <div id="{{ $post->id }}" class="post card col-4" style="width:33%; my-auto; height:40vw">
                    <h5 class="card-title">
                        <a class="link-dark link-opacity-100-hover link-opacity-50 link-offset-3-hover link-underline  link-underline-opacity-0 link-underline-opacity-100-hover" href="{{ route("posts.show" ,["id" => $post->id]) }}">{{ $post->caption }}</a>
                    </h5>

                    <img class="card-img-top" src="{{ Storage::disk('public')->url($post->images[0]->img_path) }}" alt="Card image cap">
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
                        {{-- <form method="POST" action={{ route("posts.destroy" ,["id" => $post->id]) }}>
                            @csrf
                            @method('DELETE')
                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form> --}}
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
                </div>
                </div>
            
                @endforeach
            </div>
@endsection

@section('scripts')
<script src="{{ asset("js/posts.index.js") }}"></script>
@endsection