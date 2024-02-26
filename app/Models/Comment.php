<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Post;

class Comment extends Model
{
    use HasFactory;
    protected $fillable =[
        'comment_body'
    ];
    public function post(){
        return $this->belongsTo(Post::class);  // 1:N (Comment belongs to Post)
    }

    public function user(){
        return $this->belongsTo(User::class);  // 1:N (Comment belongs to Post)
    }
}
