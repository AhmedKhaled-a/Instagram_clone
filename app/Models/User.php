<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'website',
        'image',
        'username',
        'phone',
        'gender',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    // follower_id = our id
    // user_id = followed users id

    // users that the current user follows function
    public function following(){
        return $this->belongsToMany(User::class,'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }
    // users who follow current user function
    public function followers(){
        return $this->belongsToMany(User::class,'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    // check if we follow a user
    public function follows(User $user){
        return $this->following()->where('user_id',$user->id)->exists();
    }


    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'user_blocks', 'user_id', 'blocked_user_id')->withTimestamps();
    }

    public function blockingUsers()
    {
        return $this->belongsToMany(User::class, 'user_blocks', 'blocked_user_id', 'user_id')->withTimestamps();
    }

    public function isBlocking(User $user = null) {
        if ($user) {
            return $this->blockedUsers()->where('blocked_user_id', $user->id)->exists();
        }
        return false;
    }


    public function getAvatarUrl() {
        if ($this->avatar) {
            return url('/storage/'.$this->avatar);
        }

        return  asset('img/default_user_img.png');
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }
}
