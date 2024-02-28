<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store(string $id, Request $request)
    {

        $data= $request->validate([
            'comment_body' => 'required|string|max:255',
        ]);

        // $user = User::findOrFail(1);
        $user = Auth::user();
        $post = Post::findOrFail($id);
        $comment= new Comment();
        $comment->user_id = $user->id;
        $comment->post_id = $post->id;
        $comment->comment_body= $data['comment_body'];
            // $comment->user_id=auth()->user()->id;
        $comment->save();
        return response()->json(['message' => 'Comment Added', 'id' => $comment->id]);
    }
    
    public function destroy($id){
    
      $comment=Comment::findOrFail($id);
      $comment->delete();
      return response()->json(['message' => 'Comment Deleted']);
    
    }
}
