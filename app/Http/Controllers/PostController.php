<?php

namespace App\Http\Controllers;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Post_image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
       $data = $request ->validate([ 
            'caption' =>'nullable|string|max:255',
            'img_path'=>'required|image|max:3096' ,
            'tag_text'=>'nullable |array',
            'tag_text.*'=>'string|distinct'
        ]);  

        // dd($data) ;
        
        //save image in storage 
        $imgPath=Storage::putFile('public/posts',$data['img_path']);
        //creating new post
       ;
        $post=Post::create([
         'caption'=>$data['caption']]);
        //assign img path to post
        // Post_image::create([
        //     'post_id'=>$post->id,
        //     'img_path'=>$imgPath
        // ]);

        $postImage = new Post_image();
        $postImage->post_id =$post->id;
        $postImage->img_path= $imgPath;
        $postImage->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
