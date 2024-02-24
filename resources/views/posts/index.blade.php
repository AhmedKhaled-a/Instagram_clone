@extends("layouts.main")

@section("title" , "Posts")

@section("custom-css")

@endsection

@section("content")
        <h1>Posts</h1>
            <div class="row gap-3 justify-content-center align-items-center">
                @foreach ($posts as $post)
                <div onclick="postClick(this)" id="{{ $post->id }}" class="card col-12" style="width: 18rem; my-auto; height:28vw">
                    <h5 class="card-title">
                        <a class="link-dark link-opacity-100-hover link-opacity-50 link-offset-3-hover link-underline  link-underline-opacity-0 link-underline-opacity-100-hover" href="{{ route("posts.show" ,["id" => $post->id]) }}">{{ $post->caption }}</a>
                        {{-- Start Tags --}}
                        @if ($post->tags->count() > 0)
                            <div class="mb-2">
                                @foreach ($post->tags as $tag)
                                <span class="badge badge-light text-light bg-dark">{{ $tag->tag_text }}</span>
                                @endforeach
                            </div>
                        @endif
                        {{-- End Tags --}}
                    </h5>

                    <img class="card-img-top" src="{{ Storage::disk('public')->url($post->images[0]->img_path) }}" alt="Card image cap">
                    <div class="card-body">
                    {{-- TODO: Make delete into an AJAX --}}
                    <form method="POST" action={{ route("posts.destroy" ,["id" => $post->id]) }}>
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                    </div>
                </div>
            
                @endforeach
            </div>
@endsection

@section('scripts')
<script src="{{ asset("js/posts.js") }}"></script>
@endsection