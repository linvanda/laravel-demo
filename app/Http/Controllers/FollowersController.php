<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        if ($user->id === Auth::user()->id) {
            return redirect()->route('users.show');
        }

        if (! Auth::user()->isFollowing($user->id)) {
            Auth::user()->follow($user->id);
        }

        session()->flash('success', '关注成功！');

        return back();
    }

    public function destroy(User $user)
    {
        if (Auth::user()->isFollowing($user->id)) {
            Auth::user()->unfollow($user->id);
        }

        session()->flash('success', '取消关注成功！');

        return back();
    }
}
