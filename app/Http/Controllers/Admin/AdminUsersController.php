<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserIndexRequest;
use App\Http\Requests\StoreAdminUserRequest;
use App\Http\Requests\UpdateAdminUserRequest;
use App\Models\AdminUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminUsersController extends Controller
{
    private AdminUser $adminUser;

    public function __construct(AdminUser $adminUser)
    {
        $this->adminUser = $adminUser;
        $this->authorizeResource(AdminUser::class, 'admin_user');
    }

    /**
     * Display a listing of the resource.
     *
     * @param AdminUserIndexRequest $request
     * @return View
     */
    public function index(AdminUserIndexRequest $request): View
    {
        $getAdminUsersQuery = AdminUser::query()
            // 名称で検索
            ->when($request->keyword() != '', function($query) use ($request){
                return $query->where('name', 'LIKE', '%' . $request->keyword() . '%');
            })
            // メールアドレスで検索
            ->when($request->email() != '', function($query) use ($request){
                return $query->where('email', 'LIKE', $request->email() . '%');
            })
            // 権限で検索
            ->when($request->is_owner() != 'all', function($query) use ($request){
                return $query->where('is_owner', $request->is_owner());
            })
            ->orderBy($request->element(), $request->direction());

        $adminUsers = $getAdminUsersQuery->paginate($request->count());

        return view('admin.admin_users.index', ['adminUsers' => $adminUsers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $adminUser = $this->adminUser;

        return view('admin.admin_users.create', ['adminUser' => $adminUser]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdminUserRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminUserRequest $request): RedirectResponse
    {
        $adminUser = AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_owner' => $request->is_owner,
        ]);

        return redirect()->route('admin.admin_users.show', ['admin_user' => $adminUser]);
    }

    /**
     * Display the specified resource.
     *
     * @param AdminUser $adminUser
     * @return View
     */
    public function show(AdminUser $adminUser): View
    {
        return view('admin.admin_users.show', ['adminUser' => $adminUser]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AdminUser $adminUser
     * @return View
     */
    public function edit(AdminUser $adminUser): View
    {
        return view('admin.admin_users.edit', ['adminUser' => $adminUser]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminUserRequest $request
     * @param AdminUser $adminUser
     * @return RedirectResponse
     */
    public function update(UpdateAdminUserRequest $request, AdminUser $adminUser): RedirectResponse
    {
        $adminUser->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => blank($request->password) ?
                $adminUser->password : Hash::make($request->password),
            'is_owner' => Auth::User()->is_owner ?
                $request->is_owner : 0,
        ]);

        return redirect()->route('admin.admin_users.show', ['admin_user' => $adminUser]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AdminUser $adminUser
     * @return RedirectResponse
     */
    public function destroy(AdminUser $adminUser): RedirectResponse
    {
        if (Auth::User() != $adminUser) {
            $adminUser->delete();
        } else {
            abort(403);
        }

        return redirect()->route('admin.admin_users.index');
    }
}
