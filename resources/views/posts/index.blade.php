@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")
<link rel="stylesheet" href="{{ asset("css/posts.css") }}">
<link rel="stylesheet" href="{{ asset("css/post-carousel.css") }}">
<link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet"/>
@endsection

@section("content")
        <h1>Posts</h1>        
        <div class="box my-5">
            <form method="get" action={{ route('posts.search') }}>
                @csrf
                    <input type="text" class="input" name="search" onmouseout="this.value = ''; this.blur();">
                    <i id="searchIcon" class="fas fa-search"></i>
            </form>
        </div>
@include('posts.posts')
<div class="row justify-content-center align-items-center w-75 my-auto">
    {!! $posts->links() !!}
</div>
@endsection

@section('scripts')

<script type="module" src="{{ asset("js/posts.index.js") }}"></script>
@endsection
