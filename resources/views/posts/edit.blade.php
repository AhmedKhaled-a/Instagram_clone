@extends("layouts.main")


@section("title" , "edit")
@section("custom-css")
    <link rel="stylesheet" href="{{ asset("css/edit.css")}}">
@endsection

@section("content")
@if ($post == '') 
    No post with this id
@else
<h1>Editing Post {{ $post->id }} </h1>
<div class="border border-3 border-radius-50">
    <form method="post" action={{ route("posts.update" ,["id" => $post->id]) }}> 
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="images" class="form-label">Upload Image (png,jpg,jpeg)</label>
                <input type="file" name="images[]" id="images" multiple="multiple" accept="image/jpeg, image/png, image/jpg" onchange="previewImage(event);">        
            </div>
            <div class="image-preview-container">
                
                @foreach ($post->images as $image )
                    <div class="preview">
                        <img id="preview-selected-image" src="{{ Storage::disk('public')->url($image->img_path) }}">
                    </div>
                @endforeach

            </div>
            <div class="mb-3">
                <label for="body" class="form-label">Post Body</label>
                <div class="container">
                    <input type="text" value="{{ old("body") }}" name="body" id="body" class="form-control">  
                </div>         
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endif

@endsection

@section("scripts")
@parent
    <script src="{{ asset("js/edit.js") }}"></script>
@endsection