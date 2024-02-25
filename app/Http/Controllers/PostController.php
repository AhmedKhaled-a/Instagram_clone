<?php
namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Post_image;
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

        $posts = Post::with(['tags', 'comments', 'images'])->paginate(6);


        $likedPostsIDs = [];
        
            $result = Post::join('likes', 'posts.id', '=', 'likes.post_id')
            ->join('users', 'likes.user_id', '=', 'users.id')->get();
            // dd($result);
            
        
        foreach($result as $likedPost) {
            // dd($likedPost);
            array_push($likedPostsIDs, $likedPost->post_id);
        }
        // dd($result);
        // dd($likedPostsIDs);       
        return view('posts.index', [
            'posts' => $posts,
            'likedPostsIDs' => $likedPostsIDs,

        ]);
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

        // $user_id = Auth::id();

        // Validate data
        $data = $request->validate([ 
            'caption' => 'nullable|string|max:255',
            'images' => 'required',
            'tag_text' => 'nullable',
            // 'tag_text.*' => 'string|distinct'
        ]);
        
            
    $user=User::findOrFail(1);
        // Create new post
        $extractedTags = PostController::getTags($data['caption']);
        $caption = trim($extractedTags[0]);
        array_shift($extractedTags);

        $post = Post::create([
            'caption' => $caption,
            'user_id' => $user->id,
        ]);
    
        $imagePath = '';
        
        $imageFiles = $request->file('images');
        // dd($imageFiles);
        $manager = new ImageManager(new Driver());

        foreach ($imageFiles as $imageFile) {    
            $image_name = Str::random(18) . "." . $imageFile->extension();
            $img = $manager->read($imageFile);
            $img = $img->resize(400, 400);
            $img = $img->toJpeg(80)->save(storage_path("app/public/posts/" . $image_name));
            // Todo: Add multiple post images
            $imagePath = "posts/" . $image_name;
            $postImage = new Post_image();
            $postImage->post_id =$post->id;
            $postImage->img_path = $imagePath;

            // $postImage->save();
            $post->images()->save($postImage);
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
            'images'=>'required'
        ]);

        // dd($extractedTags);
        $imagePath = '';
        
        $imageFiles = $request->file('images');
        // dd($imageFiles);

        foreach ($imageFiles as $imageFile) {    
            // Todo: Add multiple post images
            $imagePath = $imageFile->store('posts' , 'public');
            $postImage = new Post_image();
            $postImage->post_id =$post->id;
            $postImage->img_path = $imagePath;

            // $postImage->save();
            $post->images()->save($postImage);
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

        return redirect()->route('posts.index');
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
        return response()->redirect()->route('posts.index');

    }

    public function likes(string $id) {
        $likes = Post::find($id)->likes;
        return response()->json($likes, 200);
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
