<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:permissions,name']);
        $perm = Permission::create([
            'name' => Str::slug($request->name, '_'),
            'guard_name' => 'web'
        ]);
        return response()->json([
            'permission' => [
                'id' => $perm->id,
                'name' => $perm->name,
                'label' => $request->name
            ]
        ]);
    }
}
