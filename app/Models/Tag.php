<?php

namespace App\Models;
use App\Http\Controllers\PostController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable=['tag_text'];
    protected $table = "tags";
    
    public function posts(){
        return $this->belongsToMany(
            related: Tag::class,
            foreignPivotKey: 'tag_id',
            relatedPivotKey: 'post_id'
        ); //, 'tag_text', 'tag_id', 'post_id' Many to many relationship
    }
}
