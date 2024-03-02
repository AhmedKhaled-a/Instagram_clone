<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\UserBlock;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Searching Function
    public function index(Request $request)
    {
            $search = $request->input('search');
            $users = [];
            if ($search) {
                $users = User::where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->get();
            }
            return view('users.index', compact('users', 'search'));
        
        
    }
    
    
    public function blockUser(Request $request, User $blockedUser)
    {
        $user = $request->user();

        $userBlock = new UserBlock();

        if (!$user->blockedUsers()->find($blockedUser->id)) {
            $userBlock->blockUser($user, $blockedUser);
            return redirect()->back()->with('success', 'User blocked successfully.');
        } else {
            $user->following()->detach($blockedUser->id);
            return redirect()->back()->with('error', 'User is already blocked.');
        }
    }

    public function unblockUser(Request $request, User $user)
    {
        $userBlock = new UserBlock();

        $userBlock->unblockUser($request->user(), $user);

        return redirect()->back()->with('success', 'User unblocked successfully.');
    }
}
