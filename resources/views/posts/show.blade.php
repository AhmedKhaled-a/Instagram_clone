@extends('layouts.main')

@section('title', 'Post ' . '(' . $post->user->username . ')')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/posts.css') }}">

    <style>
        .comments-container {
            max-height: 400px;
            /* Adjust as needed */
            overflow-y: auto;
            /* Enable vertical scrolling */
            scrollbar-width: none;
            /* Hide scrollbar for Firefox */
        }

        .comments-container::-webkit-scrollbar {
            display: none;
            /* Hide scrollbar for Chrome, Safari, and Opera */
        }

        /* #comment_body {
                position:fixed;
                width:40%;
                top:450px;
                right:138px
            } */
        #postButton {
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

        #btn {
            position: absolute;
            right: 50px;
            top: 0px;
        }
    </style>
@endsection

@section('content')
    <span id="username">{{ Auth::user()->username }}</span>
    @if ($post == '')
        No post with this id
    @else
        <div class="container post-container">
            <!-- Button to go back to the index page -->
            <a id="btn" href="{{ route('posts.index') }}" class="btn btn-secondary h-9 py-2 mt-3"><i
                    class="fa-solid fa-xmark"></i></a>

            <div class="post-images flex-column col-6">
                <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
                    <div class="carousel-inner">
                        @foreach ($post->images as $index => $image)
                            <div class="carousel-item @if ($index === 0) active @endif">
                                <img src="{{ Storage::disk('public')->url($image->img_path) }}" class="d-block w-100"
                                    id="post-img" alt="Post image">
                            </div>
                        @endforeach
                    </div>

                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            {{-- post details --}}
            <div class="container col-5">
                <div class="row">
                    <div class="post-header">
                        <img src="{{ $post->user->getAvatarUrl() }}" alt="User Image">
                        <a href="{{ route('profile.index', ['user'=>$post->user->id], false) }}" class="text-dark text-decoration-none text-lg">{{ $post->user->name }} </a>
                    </div>
                    <hr class="border border-1">

                    <div class="post-caption text-dark">
                        <p>{{ $post->caption }}</p>
                    </div>
                    <div class="comments-container flex-column align-items-end" style="max-height: 400px; overflow-y: auto;">

                        <h6 id="commentsTitle" class="text-dark">Comments</h6>
                        <div id="commentContainer">
                            @foreach ($post->comments->reverse() as $comment)
                                <div class="comment">
                                    <div class="d-flex mb-3">
                                        <img src="{{ $comment->user->getAvatarUrl() }}" alt=""
                                            class='w-10 rounded-circle'>
                                        <a href="{{ route('profile.index', ['user'=>$comment->user->id], false) }}"
                                            class="text-dark text-decoration-none text-lg">{{ $comment->user->name }}</a>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p>{{ $comment->comment_body }}</p>
                                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div>
                                            @if (Auth::id() == $comment->user->id)
                                                <form id="deleteCommentForm_{{ $comment->id }}" method="POST" action="{{ route('comment.destroy', ['id' => $comment->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="Delete Comment" data-comment-id="{{ $comment->id }}"><i class="fa-solid fa-trash-can text-danger fs-5"></i></button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="remaining-comments" style="display: none;">
                                @foreach ($post->comments->reverse()->slice(4) as $comment)
                                    <div class="comment">
                                        <div class="d-flex mb-3">
                                            <img src="{{ $comment->user->getAvatarUrl() }}" alt=""
                                                class='w-10 rounded-circle'>
                                            <a href=""
                                                class="text-dark text-decoration-none text-lg">{{ $post->user->name }} </a>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p>{{ $comment->comment_body }}</p>
                                                <small>{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <div>
                                                {{-- <form method="POST" action="{{ route('comment.destroy' ,$comment->id) }}"> --}}
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm comment-delete-button"
                                                    data-comment-id="{{ $comment->id }}">Delete</button>
                                                {{-- </form> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                        @if ($post->comments->count() > 4)
                            <button id="showMoreCommentsButton" class="btn btn-primary mt-3">Show More Comments</button>
                        @endif


                    </div>
                    <div class="comment-form mt-3">
                        {{-- <form id="commentForm" action="{{ route('comment.store', $post->id) }}" method="post"> --}}
                        <div class="input-group">
                            <input type="text" class="form-control" name="comment_body" id="comment_body" rows="1"
                                placeholder="Add a comment..."></input>
                            <button data-post-id="{{ $post->id }}" id="postButton"
                                class="bg-transparent text-primary mt-2">Post</button>
                        </div>
                        {{-- </form> --}}

                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection

@section('scripts')
    <script type="module" src="{{ asset('js/posts.show.js') }}"></script>
@endsection
