<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show', 'create', 'store', 'confirmEmail']
        ]);

        $this->middleware('guest', ['only' => ['create']]);
    }

    public function index()
    {
        $users = User::paginate(5);

        return view('users.index', compact('users'));
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
            'password' => bcrypt($request->password)
        ]);

        $this->sendEmailConfirmation($user);

        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');

        return redirect()->route('users.show', $user);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'required|max:255',
            'password' => 'nullable|max:255|min:4|confirmed'
        ]);

        $userData = ['name' => $request->name];

        if ($request->password) {
            $userData['password'] = $request->password;
        }

        $user->update($userData);

        session()->flash('success', '修改资料成功！');

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);

        $user->delete();

        session()->flash('success', '删除成功！');

        return back();
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);

        session()->flash('success', '恭喜你，激活成功！');

        return redirect()->intended(route('users.show', $user));
    }

    protected function sendEmailConfirmation(User $user)
    {
        $from = '1049180458@qq.com';
        $fName = 'linvanda';
        $to = $user->email;
        $data = compact('user');
        $subject = '账号激活通知';

        Mail::send('emails.confirm', $data, function (Message $message) use ($from, $fName, $to, $subject) {
            $message->from($from, $fName)->to($to)->subject($subject);
        });
    }
}
