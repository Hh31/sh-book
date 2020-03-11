<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * 用户信息首页
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: hefusheng 2020/3/11
     */
    public function show(User $user)
    {
        $book = Book::query()
            ->where('user_id',$user->id)
            ->where('book_status', true)
            ->paginate(8);
        return view('users.show', [
            'books' => $book,
            'user' => $user,
        ]);
    }

    /**
     * 编辑用户
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: hefusheng 2020/3/11
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * 更新用户
     * @param UserRequest $request
     * @param ImageUploadHandler $uploader
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @author: hefusheng 2020/3/11
     */
    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功！');
    }

}
