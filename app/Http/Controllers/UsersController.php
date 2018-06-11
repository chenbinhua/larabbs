<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{
    //未登陆用户只允许访问show页面
    public function __construct()
    {
        $this->middleware('auth',['except' => ['show']]);
    }

    //用户中心
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    //编辑资料
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    //更新用户资料
    public function update(UserRequest $request, User $user, ImageUploadHandler $uploader)
    {
        $this->authorize('update', $user);
        $data = $request->all();

        //如果存在上传头像则更新用户头像
        if($request->avatar){
            $result = $uploader->save($request->avatar,'avatars',$user->id, 362);
            if($result){
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '资料更新成功');
    }
}
