<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use Illuminate\Support\Facades\View;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(\Entrust::hasRole('admin'))
    	{
        	$users = DB::table('users')->leftjoin('role_user','id','=','role_user.user_id')->leftjoin('roles','role_id','=','roles.id')->select('users.name','users.email','users.id','roles.name as role_name')->groupBy('users.name')->get();
    	}
    	else
    	{
    	$users = Role::where('name', 'sub')->first()->users()->get();
    	}
    	
        return view('users.index', ['users' => $users]);
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
        $user = User::find($id);
        
        return view::make('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
  		//
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
   	
    public function giveModerator($id)
    {
    	$user = User::find($id);
    	$role = Role::where('name', '=', 'mod')->firstOrFail();
    	
    	$user->detachRoles($user->roles);
    	$user->roles()->attach($role->id);
    	 
    	//return view('home');
    	return redirect()->back();
    }
    public function takeModerator($id)
    {
    	$user = User::find($id);
    	$role = Role::where('name', '=', 'sub')->firstOrFail();
    	
    	$user->detachRoles($user->roles);
    	$user->roles()->attach($role->id);
    	 
    	//return view('home');
    	return redirect()->back();
    }
}
