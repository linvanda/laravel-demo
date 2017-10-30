<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:255'
        ]);

        Auth::user()->statuses()->create(['content' => $request->content]);

        return back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);

        $status->delete();

        session()->flash('success', '删除成功！');

        return back();
    }
}
