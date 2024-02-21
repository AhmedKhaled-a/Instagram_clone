@extends("layouts.main")


@section("title" , "Post " . $post->id)

@section("content")

@if ($post == '') 
    No post with this id
@else
    
@endif

@endsection
