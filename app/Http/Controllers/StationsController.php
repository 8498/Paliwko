<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Station;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class StationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stations = DB::table('stations')->groupBy('name')->get();
        
        return view('stations.index', ['stations' => $stations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	return view('stations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	/*$name = $request->input('name');
    	
    	DB::table('stations')->insert(['name' => $name]
	);*/
    	$station = new Station;
    	$station->name = $request->input('name');
    	$station->save();
    	
       return redirect::to('stations');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$station = Station::find($id);
    	
    	// show the edit form and pass the nerd
    	/*return View::make('stations.edit')
    	->with('station', $station);
    	return redirect::to('stations');*/
    	
    	return View::make('stations.edit')->with('station', $station);
    	
        //return redirect::to('stations'.$station.'/edit');
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
    	//$name = $request->input('name');
    	
    	//DB::table('stations')->update(['name' => $name])->where(['id' => $id]);
    	
    	$station = Station::find($id);
    	$station->name = $request->input('name');
    	$station->save();
    	//Input::get('name');
    	return Redirect::to('stations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$station = Station::find($id);
    	$station->delete();
    	
    	// redirect
    	return Redirect::to('stations');
    }
}
