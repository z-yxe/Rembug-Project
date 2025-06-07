<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // fungsi follow
    public function store(User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->id === $user->id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        if (!$currentUser->isFollowing($user)) {
            $currentUser->following()->attach($user->id);
            return back()->with('success', 'Successfully followed ' . $user->username);
        }

        return back()->with('info', 'You are already following ' . $user->username);
    }

    // fungsi unfollow 
    public function destroy(User $user)
    {
        $currentUser = Auth::user();

        if ($currentUser->isFollowing($user)) {
            $currentUser->following()->detach($user->id);
            return back()->with('success', 'Successfully unfollowed ' . $user->username);
        }

        return back()->with('info', 'You are not following ' . $user->username);
    }
}