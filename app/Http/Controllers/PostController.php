<?php
namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post_image;
use App\Models\SavedPost;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Todo: Change user id to Auth
        $user = Auth::user();
        // $userSaved = User::find($user->id)->with(['savedPosts'])->get();

        if($user) {
            $savedPosts = SavedPost::join('posts', 'posts.id', '=', 'saved_posts.post_id')
            ->join('users', 'saved_posts.user_id', '=', 'users.id')->where('users.id', '=', $user->id)->get();

            // dd($savedPosts);
            $following = $user->following;
            $followingIds = $following->map(function($follow) { return $follow->id; });
            // dd($followingIds);

            $posts = Post::with(['tags', 'images', 'user'])->whereIn('user_id' , $followingIds)->orderBy('created_at' , 'DESC')
            ->paginate(6);

            $savedPostsIds = $savedPosts->map(function($savedpost) { return $savedpost->post_id; });
            $likedPostsIDs = [];

            $result = Like::join('posts', 'posts.id', '=', 'likes.post_id')
            ->join('users', 'likes.user_id', '=', 'users.id')->where('users.id', '=', $user->id)->get();


            foreach($result as $like) {
                array_push($likedPostsIDs, $like->post_id);
            }

            return view('posts.index', [
                'posts' => $posts,
                'likedPostsIDs' => $likedPostsIDs,
                'currentUser' => $user,
                'savedPostsIds' => $savedPostsIds->toArray()

            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()

    {
       /*
       if (Auth::guest()) {
           return redirect('/login');
       }*/

        return view('posts.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: get authenticatede user

        $user_id = Auth::id();

        // Validate data
        $data = $request->validate([
            'caption' => 'nullable|string|max:255',
            'images' => 'required',
            'tag_text' => 'nullable',
            // 'tag_text.*' => 'string|distinct'
        ]);



        // Create new post
        $extractedTags = PostController::getTags($data['caption']);
        $caption = trim($extractedTags[0]);
        array_shift($extractedTags);

        $post = Post::create([
            'caption' => $caption,
            'user_id' => $user_id,
        ]);

        $imagePath = '';

        $imageFiles = $request->file('images');
        // dd($imageFiles);
        $manager = new ImageManager(new Driver());

        $storeDir = storage_path("app/public/posts/");
        if (!file_exists( $storeDir ) || !is_dir( $storeDir) ) {   mkdir($storeDir); }
        if($imageFiles) {
            foreach ($imageFiles as $imageFile) {
                $image_name = Str::random(18) . "." . $imageFile->extension();
                $img = $manager->read($imageFile);
                $img = $img->resize(800, 800);
                $img = $img->toJpeg(80)->save(storage_path("app/public/posts/" . $image_name));
                // Todo: Add multiple post images
                $imagePath = "posts/" . $image_name;
                $postImage = new Post_image();
                $postImage->post_id =$post->id;
                $postImage->img_path = $imagePath;

                // $postImage->save();
                $post->images()->save($postImage);
            }
        }

        // dd($extractedTags);

        if($extractedTags !== null){
            foreach($extractedTags as $hashtag){
                $tag = Tag::firstOrCreate(['tag_text' => $hashtag]);
                $exists = $post->tags->contains($tag);
                if(!$exists) {
                    $post->tags()->attach($tag->id);
                }
            }
        }

        return redirect()->route('posts.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        return view("posts.show" , ["post" => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // authentication
        $authenticated = true;
        if($authenticated) {
            // $post = Post::findOrFail($id)->with(["images", "tags", "comments"])->get();
            // dd($post[$id -1]);
            $post = Post::findOrFail($id);
            return view("posts.edit" , ["post" => $post]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validate([
            'caption' =>'nullable|max:255',
        ]);

        // dd($extractedTags);
        $imagePath = '';

        $imageFiles = $request->file('images');
        // dd($imageFiles);
        $manager = new ImageManager(new Driver());

        $storeDir = storage_path("app/public/posts/");
        if (!file_exists( $storeDir ) || !is_dir( $storeDir) ) {   mkdir($storeDir); }
        if($imageFiles) {
            foreach ($imageFiles as $imageFile) {
                $image_name = Str::random(18) . "." . $imageFile->extension();
                $img = $manager->read($imageFile);
                $img = $img->resize(800, 800);
                $img = $img->toJpeg(80)->save(storage_path("app/public/posts/" . $image_name));
                // Todo: Add multiple post images
                $imagePath = "posts/" . $image_name;
                $postImage = new Post_image();
                $postImage->post_id =$post->id;
                $postImage->img_path = $imagePath;

                // $postImage->save();
                $post->images()->save($postImage);
            }
        }

        $extractedTags = PostController::getTags($data['caption']);
        $caption = trim($extractedTags[0]);
        array_shift($extractedTags);

        //creating new post
        $post->update(["caption" => $caption]);

        // Attach tags to the post
        if($extractedTags !== null){
            foreach($extractedTags as $hashtag){
                $tag = Tag::firstOrCreate(['tag_text' => $hashtag]);
                $exists = $post->tags->contains($tag);
                if(!$exists) {
                    $post->tags()->attach($tag->id);
                }
            }
        }

        return redirect()->route('posts.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // remove all comments associated with post

        // remove all images associated with post
        $post = Post::find($id);
        if($post) {
            $images = $post->images;
            // dd($images);
            foreach($images as $image) {
                if(Storage::disk('public')->exists($image->img_path)) {
                    Storage::disk('public')->delete($image->img_path);
                }
                $image->delete();
            }


            // remove post itself
            $post->delete();
        }
        return redirect()->route('posts.index');

    }

    public function search(Request $request)
    {
        $user = Auth::user();

        $posts = Post::with(['tags', 'comments', 'images'])->where("caption", "LIKE" , "%" . $request->search . "%")->paginate(6);
        // dd($posts);

        $savedPosts = SavedPost::join('posts', 'posts.id', '=', 'saved_posts.post_id')
        ->join('users', 'saved_posts.user_id', '=', 'users.id')->where('users.id', '=', $user->id)->get();

        $likedPostsIDs = [];

        $result = Post::join('likes', 'posts.id', '=', 'likes.post_id')
        ->join('users', 'likes.user_id', '=', 'users.id')->get();
        $savedPostsIds = $savedPosts->map(function($savedpost) { return $savedpost->post_id; });


        foreach($result as $likedPost) {
            // dd($likedPost);
            array_push($likedPostsIDs, $likedPost->post_id);
        }

        return view('posts.index', [
            'posts' => $posts,
            'likedPostsIDs' => $likedPostsIDs,
            'currentUser' => $user,
            'savedPostsIds' => $savedPostsIds->toArray()
        ]);
    }

    public function likes(string $id) {
        $likes = Post::find($id)->likes;
        return response()->json($likes, 200);
    }

    public function toggleLike(string $id, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        // dd($data);
        $user = User::find($data['userId']);
        // dd($user);
        // Check if the user has already liked the post
        $existingLike = Like::where('user_id', $user->id)->where('post_id', $id)->first();
        $post = Post::find($id);
        if ($existingLike) {
            // If the user has already liked the post, unlike it
            $existingLike->delete();

            $post->decrement('likes');
            return response()->json(['message' => 'Post unliked successfully']);
        } else {
            // If the user has not liked the post, like it
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $id;
            $like->save();
            $post->increment('likes');
            return response()->json(['message' => 'Post liked successfully']);
        }
    }

    public function savePost(Request $request)  {
        $data = json_decode($request->getContent(), true);
        // dd($data);

        $user = User::find($data['userId']);
        // dd($user);
        // Check if the user has already liked the post
        $existingSavedPost = SavedPost::where('user_id', $user->id)->where('post_id', $data['postId'])->first();
        if ($existingSavedPost) {
            // If the user has already liked the post, unlike it
            $existingSavedPost->delete();
            return response()->json(['message' => 'Post unsaved']);
        } else {
            // If the user has not liked the post, like it
            $savedpost = new SavedPost();
            $savedpost->user_id = $user->id;
            $savedpost->post_id = $data['postId'];
            $savedpost->save();
            return response()->json(['message' => 'Post saved']);
        }

    }

    public function showSaved() {
        $user = Auth::user();
        // $userSaved = User::find($user->id)->with(['savedPosts'])->get();


        $posts = Post::join('saved_posts', 'posts.id', '=', 'saved_posts.post_id')
        ->where('saved_posts.user_id', '=', $user->id)
        ->with(['tags', 'images', 'user'])
        ->select("posts.*")
        ->paginate(6);

        $savedPostsIds = $posts->map(function($savedpost) { return $savedpost->id; });
        // dd($savedPostsIds);
        $likedPostsIDs = [];

        $result = Like::join('posts', 'posts.id', '=', 'likes.post_id')
        ->join('users', 'likes.user_id', '=', 'users.id')->where('users.id', '=', $user->id)->get();

        foreach($result as $like) {
            array_push($likedPostsIDs, $like->post_id);
        }


        return view('posts.index', [
            'posts' => $posts,
            'likedPostsIDs' => $likedPostsIDs,
            'currentUser' => $user,
            'savedPostsIds' => $savedPostsIds->toArray()
        ]);
    }

    public static function getTags($str) {
        $chars = str_split($str);
        $hashTag = "";
        $captionWithoutTags = "";
        $captionPlushashTags = [];
        $found_hash = false;
        foreach($chars as $char) {
            // echo $char;
            if($found_hash) {
                $hashTag .= $char;
            }
            else if($char != "#") {
                $captionWithoutTags .= $char;
            }
            if($char == ' ' && $found_hash == true) {
                $found_hash = false;
                array_push($captionPlushashTags, $hashTag);
                $hashTag = "";
                $captionWithoutTags .= " ";
            }
            if($char == '#') {
                $found_hash = true;
            }
        }
        if(!empty($hashTag))
            array_push($captionPlushashTags, $hashTag);
        array_unshift($captionPlushashTags, $captionWithoutTags);

        return $captionPlushashTags; // array of tags
    }
}
