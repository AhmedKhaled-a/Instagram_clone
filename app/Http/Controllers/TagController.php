<?php

namespace App\Http\Controllers;

use App\Models\SavedPost;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class TagController extends Controller
{
    public function show(string $id) 
    {
        $user = Auth::user();
        $user_id = $user->id;
        $result = Post::join('likes', 'posts.id', '=', 'likes.post_id')
            ->join('users', 'likes.user_id', '=', 'users.id')->get();
            // dd($result);
            
        $likedPostsIDs = [];
        foreach($result as $likedPost) {
            // dd($likedPost);
            array_push($likedPostsIDs, $likedPost->post_id);
        }

        $savedPosts = SavedPost::join('posts', 'posts.id', '=', 'saved_posts.post_id')
        ->join('users', 'saved_posts.user_id', '=', 'users.id')->where('users.id', '=', $user->id)->get();
        $savedPostsIds = $savedPosts->map(function($savedpost) { return $savedpost->post_id; });

        $tag = Tag::find($id);
        $posts = $tag->posts()->paginate(6);
        // dd($posts, $tag);
        return view("tags.show" , [
            "tag" => $tag , "posts" => $posts , 
            "likedPostsIDs" => $likedPostsIDs,
            "currentUser" => $user,
            "savedPostsIds" => $savedPostsIds->toArray()
        ]);
    }
}
