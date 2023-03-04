<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles/index', [
            'role_records' => Role::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $viewButtons = $request->has('viewButtons') ? $request->input('viewButtons') : 0;
        $viewUser = $request->has('viewUser') ? $request->input('viewUser') : 0;
        $addUser = $request->has('addUser') ? $request->input('addUser') : 0;
        $editUser = $request->has('editUser') ? $request->input('editUser') : 0;
        $deleteUser = $request->has('deleteUser') ? $request->input('deleteUser') : 0;
        $viewRole = $request->has('viewRole') ? $request->input('viewRole') : 0;
        $addRole = $request->has('addRole') ? $request->input('addRole') : 0;
        $editRole = $request->has('editRole') ? $request->input('editRole') : 0;
        $deleteRole = $request->has('deleteRole') ? $request->input('deleteRole') : 0;


        $role = new Role();
        $role->name = $request->input('name');
        $role->save();

        $role_id = Role::where('name', $request->input('name'))->first()->id;

        $rows = [
            ['role_id' => $role_id, 'permissions_id' => $viewButtons],
            ['role_id' => $role_id, 'permissions_id' => $viewUser],
            ['role_id' => $role_id, 'permissions_id' => $addUser],
            ['role_id' => $role_id, 'permissions_id' => $editUser],
            ['role_id' => $role_id, 'permissions_id' => $deleteUser],
            ['role_id' => $role_id, 'permissions_id' => $viewRole],
            ['role_id' => $role_id, 'permissions_id' => $addRole],
            ['role_id' => $role_id, 'permissions_id' => $editRole],
            ['role_id' => $role_id, 'permissions_id' => $deleteRole],
        ];
        -
        DB::table('role_permissions')->insert($rows);
        return redirect()->route('roles.index')->with([
            'message' => 'New role created',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission_records = RolePermission::all()->where('role_id', $id);
        foreach ($permission_records as $permission_record) {
            $role_permissions[] = $permission_record->permissions_id;
        }

        return view('roles/edit', [
            "roles" => Role::find($id),
            "role_permissions" => $role_permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Buttons
        $viewButtons = $request->has('viewButtons') ? $request->input('viewButtons') : 0;

        // User
        $viewUser = $request->has('viewUser') ? $request->input('viewUser') : 0;
        $addUser = $request->has('addUser') ? $request->input('addUser') : 0;
        $editUser = $request->has('editUser') ? $request->input('editUser') : 0;
        $deleteUser = $request->has('deleteUser') ? $request->input('deleteUser') : 0;

        // Role
        $viewRole = $request->has('viewRole') ? $request->input('viewRole') : 0;
        $addRole = $request->has('addRole') ? $request->input('addRole') : 0;
        $editRole = $request->has('editRole') ? $request->input('editRole') : 0;
        $deleteRole = $request->has('deleteRole') ? $request->input('deleteRole') : 0;

        $permissions = [$viewButtons, $viewUser, $addUser, $editUser, $deleteUser, $viewRole, $addRole, $editRole, $deleteRole];


        $role = Role::find($id);
        $role->name = $request->name;
        $role->update();


        $role_id = Role::where('name', $request->name)->first()->id;
        $permission_records = RolePermission::all()->where('role_id', $role_id);
        $count = 0;
        foreach ($permission_records as $permission_record) {
            $role_permissions = RolePermission::find($permission_record->id);
            $role_permissions->permissions_id = $permissions[$count];
            $role_permissions->update();
            $count++;
        }
        return redirect()->route('roles.index')->with([
            'message' => 'Role update successfully',
            'type' => 'success',
            'duration' => 5000,
            'dismissible' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role_id = isset(User::where('role_id', $id)->first()->role_id) ? User::where('role_id', $id)->first()->role_id : 'clearUser';

        if ($role_id === 'clearUser') {
            RolePermission::where('role_id', $id)->delete();
            Role::find($id)->delete();
            return back()->with([
                'message' => 'Role delete successfully',
                'type' => 'success',
                'duration' => 5000,
                'dismissible' => true,
            ]);
        } else {
            return back()->with('warning-message', 'This role is associated with one or more user accounts. Delete the user accounts or associate them with different role.');
        }
    }

    public function roleControl()
    {
        $permission_records = RolePermission::all()->where('role_id', Auth::user()->role_id);
        foreach ($permission_records as $permission_record) {
            $role_permissions[] = $permission_record->permissions_id;
        }
        return $role_permissions;
    }
}
