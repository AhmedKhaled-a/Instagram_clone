<?php

namespace App\Models;
use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable =['caption'];


    public function comments(){
        return $this->hasMany(Comment::class);  //one to many relationship
    }

    public function images(){
        return $this->hasMany(Post_image::class);    // one to many relation
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);    //many to many relation
    }

    public function likes(){
        return $this->hasMany(Like::class);   //one to many relation
    }
    
}

