@extends("layouts.main")


@section("title" , "edit")
@section("custom-css")
    <link rel="stylesheet" href="{{ asset("css/posts.css")}}">
@endsection

@section("content")
@if ($post == '')
    No post with this id
@else
<h1>Editing Post {{ $post->id }} </h1>
<div class="border border-3 rounded p-5">
    <form method="post" action={{ route("posts.update" ,["id" => $post->id]) }} enctype="multipart/form-data"> 
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="images" class="form-label">Upload Image (png,jpg,jpeg)</label>
                <input type="file" name="images[]" id="images" multiple="multiple" accept="image/jpeg, image/png, image/jpg">        
            </div>
            <div class="mb-3">
                <label for="caption" class="form-label">Caption</label>
                <div class="container">
                    <input type="text" value="{{ $post->caption != "" ? $post->caption : old("caption")  }}" name="caption" id="caption" class="form-control">  
                </div>         
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <div class="image-preview-container">
                
        @foreach ($post->images as $image )
            <div onclick="imageClick(this)" class="preview">
                <img id="{{ $image->id }}" class="align-center preview-selected-image" src="{{ Storage::disk('public')->url($image->img_path) }}">
                <div class="middle">
                    <div class="text">Delete</div>
                </div>
            </div>            
        @endforeach
    </div>
</div>
@endif

@endsection

@section("scripts")
@parent
    <script src="{{ asset("js/posts.create.update.js") }}"></script>
@endsection