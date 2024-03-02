@extends("layouts.main")
@section("title" , "create")
@section("custom-css")
    <link rel="stylesheet" href="{{ asset("css/posts.css")}}">
@endsection

@section("content")
<h1>Create Post </h1>

<div class="border border-3 rounded p-5">
    <form method="post" action={{ route("posts.store") }} enctype="multipart/form-data"> 
            @csrf
            @method('POST')
            <div class="mb-3 p-5">
                <label for="images" class="form-label">Upload Image (png,jpg,jpeg)</label>
                <input type="file" name="images[]" id="images" multiple="multiple" accept="image/jpeg, image/png, image/jpg">        
            </div>
            <div class="mb-3">
                <label for="caption" class="form-label">Caption</label>
                <div class="">
                    <input type="text" value="{{  old("caption")  }}" name="caption" id="caption" class="form-control">  
                </div>         
            </div>
            <button type="submit" class="btn btn-primary">Add Post</button>
    </form>
    <div class="image-preview-container my-3 border-0">              
    </div>
</div>
@endsection

@section("scripts")
@parent
    <script src="{{ asset("js/posts.create.update.js") }}"></script>
@endsection