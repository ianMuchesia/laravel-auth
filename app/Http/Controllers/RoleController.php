<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\View\View;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        //
        $roles = Role::all();
        $i = 0;
        return view('roles.index',compact('roles','i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        //
        $permissions = Permission::all();

        return view('roles.create',compact("permissions"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permission);

        return back()->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id):View
    {
        //
        $role = Role::find($id);
        $permissions = Permission::get();
        $rolePermission = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('roles.edit',compact('role','permissions','rolePermission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'permission' => 'required',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permission);

        return back()->with("sucess","Role updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        //
        $role->delete();
        return back()->with("success","Role deleted successfully");
    }
}
