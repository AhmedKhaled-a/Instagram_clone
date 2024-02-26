<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Tag;


class Post extends Model
{
    use HasFactory;
    protected $fillable =['caption', 'user_id'];


    public function comments(){
        return $this->hasMany(Comment::class);  //one to many relationship
    }

    public function images(){
        return $this->hasMany(Post_image::class);    // one to many relation
    }

    public function tags(){
        return $this->belongsToMany(
            related: Tag::class,
            foreignPivotKey: 'post_id',
            relatedPivotKey: 'tag_id'
        );    
    }

    public function likes(){
        return $this->hasMany(Like::class);   //one to many relation
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

