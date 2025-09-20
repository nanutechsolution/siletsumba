<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles.permissions')->get();
        $roles = Role::with('permissions')->get();
        // ambil permissions dari roles untuk frontend
        $users->transform(function ($user) {
            $userPermissions = $user->roles->flatMap(fn($r) => $r->permissions)->pluck('name')->unique();
            $user->permissions = $userPermissions;
            return $user;
        });

        return view('admin.users.index', compact('users', 'roles'));
    }


    public function assignRoles(Request $request, User $user)
    {
        $user->syncRoles($request->roles ?? []);
        return response()->json(['success' => true, 'roles' => $user->roles]);
    }

    public function assignPermissions(Request $request, User $user)
    {
        $user->syncPermissions($request->permissions ?? []);
        return response()->json(['success' => true, 'permissions' => $user->permissions]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'array'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        if (!empty($data['roles'])) $user->syncRoles($data['roles']);

        $user->load('roles.permissions');

        return response()->json(['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'array'
        ]);

        $user->update(['name' => $data['name'], 'email' => $data['email']]);

        $user->syncRoles($data['roles'] ?? []);

        $user->load('roles.permissions');

        return response()->json(['user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User berhasil dihapus']);
    }
}
