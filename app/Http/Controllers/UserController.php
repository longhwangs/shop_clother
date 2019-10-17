<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $listUser = User::with('role');
        if ($request->search) {
            $listUser = $listUser->where('name', 'LIKE', '%'.$request->search.'%')
                                    ->orWhere('email', 'LIKE', '%'.$request->search.'%')
                                    ->orWhere('role_id', 'LIKE', '%'.$request->search.'%');
        }
        if ($request->role) {
            $listUser->where('role_id', $request->role);
        }
        $listUser = $listUser->orderBy('id', 'DESC')->paginate(10);
        $roles = Role::all();
        return view('admin.pages.user.index', compact('listUser', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        if ((Auth::user()->role_id == 2) && ($user->role_id == 1 || ($user->role_id == 2 && (Auth::user()->id != $id)))) {
            return redirect()->route('user.index')->with(['type_message' => 'danger', 'flash_message' => 'Sorry ! You can\'t edit user.']);
        }
        return view('admin.pages.user.edit', compact('roles', 'user', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();
        $user->update($data);

        $user->password = \Hash::make($request->password);
        $user->save();
        return redirect()->route('user.index')->with(['type_message' => 'success', 'flash_message' => 'Success ! Complete edit user.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_login = Auth::user()->id;
        $user = User::find($id);
        if ((Auth::user()->role_id == 2) && ($user->role_id == 1 || ($user->role_id == 2 && (Auth::user()->id != $id))) || $user->role_id == 1) {
            return redirect()->route('user.index')->with(['type_message' => 'danger', 'flash_message' => 'Sorry ! You can\'t delete user.']);
        } else {
            $user->delete();
            return redirect()->route('user.index')->with(['type_message' => 'success', 'flash_message' => 'Success ! Complete delete user.']);
        }
    }
}
