<?php
namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Post_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['tags', 'comments', 'images'])->get();
        // eager loading for all related models in one query
        
        return view('posts.index', [
            'posts' => $posts,
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
        // validate data
       $data = $request->validate([ 
            'caption' =>'nullable|string|max:255',
            'images'=>'required|image|max:3096' ,
            'tag_text'=>'nullable |array',
            'tag_text.*'=>'string|distinct'
        ]);  

        // dd($data) ;
        $imagePath = '';
        // dd($request->file('images'));
        //save image in storage 
        if($request->file('images')->isValid()) {
            $imagePath = $request->file('images')->store('posts' , 'public');
        }
        //creating new post
        
        $post = Post::create([
            'caption' => $data['caption'],
        ]);
        //assign img path to post
        // Post_image::create([
        //     'post_id'=>$post->id,
        //     'img_path'=>$imgPath
        // ]);

        $postImage = new Post_image();
        $postImage->post_id =$post->id;
        $postImage->img_path= $imagePath;
        // $postImage->save();
        $post->images()->save($postImage);
                // Attach tags to the post
                if($data['tag_text'] !== null){
                    foreach($data['tag_text'] as $hashtag){
                        $tag = Tag::firstOrCreate(['tag_text' => $hashtag]);
                        $post->tags()->attach($tag->id);     
                    }
                }
       
                return redirect()->route('posts.index');
        
        }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        $extractedTags = PostController::getTags($data['caption']);
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

        //creating new post
        $post->update(["caption" => $data["caption"]]);
        
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
        $images = $post->images;
        // dd($images);
        foreach($images as $image) {
            Storage::disk('public')->delete($image->img_path);
            $image->delete();
        }


        // remove post itself
        $post->delete();

        return redirect()->route('posts.index');
    }

    public static function getTags($str) {
        $chars = str_split($str);
        $hashTag = "";
        $hashTags = [];
        $found_hash = false;
        foreach($chars as $char) {
            // echo $char;
            if($found_hash) {
                $hashTag .= $char;
            }
            if($char == ' ' && $found_hash == true) {
                $found_hash = false;
                array_push($hashTags, $hashTag);
                $hashTag = "";
            }
            if($char == '#') {
                $found_hash = true;
            }
        }
        if(!empty($hashTag))
            array_push($hashTags, $hashTag);

        return $hashTags;
    }
}
