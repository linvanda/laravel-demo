<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * 用户注册页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:10',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        session()->flash('success', '恭喜你，注册成功！');

        return redirect()->route('users.show', $user);
    }

    public function edit(User $user)
    {
        return view('users.edit');
    }

    public function destroy(User $user)
    {
        return 'destroyed';
    }
}
