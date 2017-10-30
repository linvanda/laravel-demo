<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['create']]);
    }

    /**
     * 登录页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * 登录
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->has('remember'))) {
            if (Auth::user()->activated) {
                session()->flash('success', '登录成功！');

                return redirect()->intended(route('users.show', [Auth::user()]));
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活');

                return redirect('/');
            }

        } else {
            session()->flash('danger', '抱歉，邮箱和密码不匹配');

            return redirect()->back();
        }
    }

    /**
     * 退出登录
     */
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '退出登录');

        return redirect()->route('login');
    }
}
