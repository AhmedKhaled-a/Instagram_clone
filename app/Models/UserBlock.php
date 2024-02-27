<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    use HasFactory;

    protected $table = 'user_blocks';

    public function blockUser(User $user, User $blockedUser) {
        if ($user->follows($blockedUser)) {
            $user->following()->detach($blockedUser->id);
        }

        if ($blockedUser->follows($user)) {
            $blockedUser->following()->detach($user->id);
        }

        $user->blockedUsers()->attach($blockedUser->id);
    }

    public function unblockUser(User $user, User $blockedUser) {
        $user->blockedUsers()->detach($blockedUser->id);
    }
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blockedUser() {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
