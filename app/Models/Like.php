<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\LikeController;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }   
}