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
    #comment_body {
        position:fixed;
        width:40%;
        top:450px;
        right:138px
    }
    #postButton{
        position:fixed;
        bottom:201px;
        right:140px;
        font-weight:bold;
        z-index: 33;
    }
    #comment_body:focus {
        outline: none;
        box-shadow: 0 1px 6px 0 rgba(0, 0, 0, 0.5);
        border-radius: 0.5rem;    
    }
    #btn{
        position: absolute;
        right:50px;
        top:0px
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

    <div class="comments-container" style="max-height: 400px; overflow-y: auto;">
        <div class="comment-form mt-3">
            <form id="commentForm" action="{{ route('comment.store', $post->id) }}" method="post">
                @csrf
                <div class="input-group">
                    <textarea class="form-control" name="comment_body" id="comment_body" rows="1" placeholder="Add a comment..."></textarea>
                    <button type="submit" id="postButton" class="bg-transparent text-primary mt-2" style="display: none">Post</button>
                </div>
            </form>
        </div>

        <div class="post-header">
            <img src="{{ asset('avatar/avatar.jpg') }}" alt="User Image">
            <a href="" class="text-dark text-decoration-none mb-3 text-lg">{{ $post->user->name }} </a>
        </div>

        <div class="post-caption">
            <p>{{ $post->caption }}</p>
        </div>

        <h6 class="text-dark">Comments</h6>
        @foreach($post->comments->take(4) as $comment)
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

        @if($post->comments->count() > 4)
        <button class="btn btn-primary mt-3" onclick="showMoreComments()">Show More Comments</button>
        @endif

        <div class="remaining-comments" style="display: none;">
            @foreach($post->comments->slice(4) as $comment)
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
        </div>
    </div>

</div>

@endif

@endsection

@section("scripts")
<script>
    function showMoreComments() {
        document.querySelector('.remaining-comments').style.display = 'block';
        document.querySelector('.btn-primary').style.display = 'none';
    }

    // Function to toggle the visibility of the post button based on textarea content
    document.getElementById('comment_body').addEventListener('input', function() {
        let postButton = document.getElementById('postButton');
        if (this.value.trim() !== '') {
            postButton.style.display = 'inline-block';
        } else {
            postButton.style.display = 'none';
        }
    });

document.getElementById('commentForm').addEventListener('submit', function(event) {
    event.preventDefault();
    let form = event.target;
    let formData = new FormData(form);
    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add the new comment to the comments container
            let commentContainer = document.querySelector('.comments-container');
            let newCommentHTML = `
                <div class="comment">
                    <div class="d-flex mb-3">
                        <img src="{{ asset('avatar/avatar.jpg') }}" alt="" class='w-10 rounded-circle'>
                        <a href="" class="text-dark text-decoration-none text-lg">${data.comment.user.name}</a>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>${data.comment.comment_body}</p>
                            <small>${data.comment.created_at}</small>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('comment.destroy', $comment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm comment-delete-button">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            commentContainer.insertAdjacentHTML('beforeend', newCommentHTML);

            // Clear the comment textarea and hide the post button
            document.getElementById('comment_body').value = '';
            document.getElementById('postButton').style.display = 'none';
        } else {
            console.error(data.message); // Log any error messages returned from the server
        }
        document.getElementById('comment_body').addEventListener('keydown', function(event) {
    // Check if the enter key was pressed (keyCode 13) and not in combination with shift key (to allow multiline)
    if (event.keyCode === 13 && !event.shiftKey) {
        // Prevent the default behavior of the enter key
        event.preventDefault();
        // Trigger a submit event on the form
        document.getElementById('commentForm').submit();
    }
});

    })
    .catch(error => console.error('Error:', error));
});

    
</script>
@endsection
