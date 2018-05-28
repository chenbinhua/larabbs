<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //用户中心
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //编辑资料
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    //更新用户资料
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());
        return redirect()->route('users.show', $user->id)->with('success', '资料更新成功');
    }
}
