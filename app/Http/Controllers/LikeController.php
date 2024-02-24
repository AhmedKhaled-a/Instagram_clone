<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggleLike(Request $request, $postId)
    {
        // Find the authenticated user
        $user = User::findOrFail(1);
    
        // Check if the user has already liked the post
        $existingLike = Like::where('user_id', $user->id)->where('post_id', $postId)->first();
    
        if ($existingLike) {
            // If the user has already liked the post, unlike it
            $existingLike->delete();
            return response()->json(['message' => 'Post unliked successfully']);
        } else {
            // If the user has not liked the post, like it
            $like = new Like();
            $like->user_id = $user->id;
            $like->post_id = $postId;
            $like->save();
            return response()->json(['message' => 'Post liked successfully']);
        }
    }
}               


