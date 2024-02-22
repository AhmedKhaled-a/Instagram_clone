<?php

namespace App\Models;
use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_image extends Model
{
    use HasFactory;
    protected $fillable = ['img_path'];
    
    public function post(){
        return $this->belongsTo(Post::class); // img belongs to one post 1:N
    }
}
