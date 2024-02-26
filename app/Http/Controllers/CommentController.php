<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    public function store($id,Request $request)
    {

        $data= $request->validate([
            'comment_body' => 'required|string|max:255',
            'id'=>'exists:posts,id',
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
        return redirect()->route('posts.index');
    }
    
    public function destroy($id){
    
      $comment=Comment::findOrFail($id);
      $comment->delete();
      return redirect()->route('posts.index');
    
    }
}
