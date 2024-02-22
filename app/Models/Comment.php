<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable =[
        'comment_body'
    ];
    public function post(){
        return $this->belongsTo(Post::class);  // 1:N (Comment belongs to Post)
    }
}
