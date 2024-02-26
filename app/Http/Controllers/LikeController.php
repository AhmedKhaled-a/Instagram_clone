<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class LikeController extends Controller
{
    // public function toggleLike(Request $request, String $id)
    // {
    //     // Find the authenticated user
    //     $user_id = Auth::id();
    //     // $user = User::findOrFail(1);
    
    //     // Check if the user has already liked the post
    //     $existingLike = Like::where('user_id', $user_id )->where('post_id', $id)->first();
    //     $post = Post::find($id);
    //     if ($existingLike) {
    //         // If the user has already liked the post, unlike it
    //         $existingLike->delete();
            
    //         $post->decrement('likes');
    //         return response()->json(['message' => 'Post unliked successfully']);
    //     }

    //     else {
    //         // If the user has not liked the post, like it
    //         $like = new Like();
    //         // $like->user_id = $user_id;
    //         // $like->post_id = $id;
    //         $like->post()->associate($post);
    //         $like->user()->associate(User::findOrFail($user_id));

    //         $like->save();
    //         $post->increment('likes');
    //         return response()->json(['message' => 'Post liked successfully']);
    //     }
    // }

    public function toggleLike(Request $request, String $id)
    {
        
    }
}               


