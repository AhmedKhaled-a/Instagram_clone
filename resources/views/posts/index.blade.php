<!-- resources/views/posts/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <!-- Add your CSS stylesheets if needed -->
    <style>
        <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f8f9fa;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        padding: 0 20px;
    }

    .card {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-title {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .card-text {
        color: #333;
        margin-bottom: 20px;
    }

    .badge {
        background-color: #007bff;
        color: #fff;
        border-radius: 4px;
        padding: 4px 8px;
        margin-right: 5px;
    }
</style>

    </style>
</head>
<body>
    <div class="container">
        <h1>Posts</h1>
        
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->id }}</h2>
                    <p class="card-text">{{ $post->caption }}</p>
                    <img src="{{ asset(str_replace('public', 'storage', $post->img_path)) }}" alt="Post Image">
                    
                    @if ($post->tags->count() > 0)
                        <div class="mb-2">
                            <strong>Tags:</strong>
                            @foreach ($post->tags as $tag)
                                <span class="badge badge-secondary">{{ $tag->tag_text }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
</body>
</html>
