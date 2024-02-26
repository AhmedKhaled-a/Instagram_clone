@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<link rel="stylesheet" href="{{ asset('css/posts.css') }}">
@endsection

@section("content")
    <h1>Posts</h1>
    <div class="row gap-3 justify-content-center align-items-center">
        @foreach ($posts as $post)
            <div id="{{ $post->id }}" class="post card col-6 justify-content-center">
                <h5 class="post-title card-title">
                    <a class="link-dark" href="{{ route('posts.show', ['id' => $post->id]) }}">{{ $post->caption }}</a>
                </h5>

                  <div id="carouselExampleIndicators" class="carousel slide col-12 w-75 mx-auto" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($post->images as $index => $image)
                            <div class="carousel-item @if ($index === 0) active @endif">
                                <img class="my-auto d-block w-75 mx-auto post-image" style="height: 200px;" src="{{ Storage::disk('public')->url($image->img_path) }}" alt="Post image">
                            </div>
                        @endforeach
                    </div>
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
                                <a class="badge badge-light text-light bg-dark" href="{{ route('tags.show', ['id' => $tag->id]) }}">{{ $tag->tag_text }}</a>
                            @endforeach
                        </div>
                    @endif
                    {{-- End Tags --}}


                    <!-- Anchor tag to view all comments -->
                    <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="text-dark text-decoration-none mt-3">View All Comments</a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- X button to navigate back to the index page -->

    <div class="row justify-content-center align-items-center w-75 my-auto">
        {!! $posts->links() !!}
    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @section('scripts')
        <script src="{{ asset('js/posts.index.js') }}"></script>
    @endsection
@endsection
