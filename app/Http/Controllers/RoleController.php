<?php

namespace App\Http\Controllers;

use App\Role;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
    }

    public function create()
    {
        $users = User::where('id',"!=",Auth::user()->id)->get();
        $roles = roles::get();
        return view('userrequest')->with('users',$users)->with('roles',$roles);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'fk_role_id' => $request->fk_role_id,
            'status' => 'approved',
            'password' => Hash::make($request->password),
        ]);
        return redirect()->back();
    }

    public function show(Role $role)
    {
        //
    }

    public function edit(Role $role)
    {
        //
    }

    public function update(Request $request, Role $role)
    {
        //
    }

    public function destroy(Role $role)
    {
        //
    }
}
