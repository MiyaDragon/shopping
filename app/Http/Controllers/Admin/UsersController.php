<?php

namespace App\Http\Controllers\Admin;

use App\Consts\UsersConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserIndexRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UsersController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserIndexRequest $request
     * @return View
     */
    public function index(UserIndexRequest $request): View
    {
        $getUsersQuery = User::query()
            // 名称で検索
            ->when($request->keyword() != '', function ($query) use ($request){
                return $query->where('keyword', 'LIKE', '%' . $request->keyword() . '%');
            })
            // メールアドレスで検索
            ->when($request->email() != '', function ($query) use ($request){
                return $query->where('email', 'LIKE', $request->keyword() . '%');
            })
            ->orderBy($request->element(), $request->direction());

        $users = $getUsersQuery->paginate($request->count());

        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $user = $this->user;

        return view('admin.users.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (filled($request->file('image_path'))) {
            $file = $request->file('image_path');
            $file_name = $file->hashName();
            Storage::disk(UsersConst::DISK)
                ->putFileAs(UsersConst::DIR, $request->file('image_path'), $file_name);
            $user->image_path = UsersConst::DIR . '/' . $file_name;
            $user->save();
        }

        return redirect()->route('admin.users.show', ['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        // チェックボックスにチェックがある場合はイメージを削除
        if (filled($request->delete)) {
            Storage::disk(UsersConst::DISK)->delete($user->image_path);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => blank($request->password) ?
                $user->password : Hash::make($request->password),
        ]);

        if (filled($request->file('image_path'))) {
            // 古いイメージがある場合は削除
            if (Storage::disk(UsersConst::DISK)->exists($user->image_path)) {
                Storage::disk(UsersConst::DISK)->delete($user->image_path);
            }
            $file = $request->file('image_path');
            $file_name = $file->hashName();
            Storage::disk(UsersConst::DISK)
                ->putFileAs(UsersConst::DIR, $request->file('image_path'), $file_name);
            $user->image_path = UsersConst::DIR . '/' . $file_name;
            $user->save();
        }

        return redirect()->route('admin.users.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        if (Storage::disk(UsersConst::DISK)->exists($user->image_path)) {
            Storage::disk(UsersConst::DISK)->delete($user->image_path);
        }

        $user->delete();

        return redirect()->route('admin.users.index');
    }
}
