<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Station;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Response;
use App\Company;
use Auth;

class StationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	if(Auth::user()->hasRole('sub'))
    	{
	        $stations = DB::table('stations')->leftjoin('company_station','id','=','company_station.station_id')
	        ->leftjoin('companies','company_id','=','companies.id')->where('stations.verify','=','true')
	        ->select('stations.name','stations.id','companies.name as company_name', 'companies.id as company_id', 'companies.color','stations.LPG','stations.ON','stations.PB95','stations.PB98')
	        ->groupBy('stations.name')->get();
    	}
    	else 
    	{
    		$stations = DB::table('stations')->leftjoin('company_station','id','=','company_station.station_id')
    		->leftjoin('companies','company_id','=','companies.id')
    		->select('stations.name','stations.id','stations.verify','companies.name as company_name', 'companies.id as company_id', 'companies.color','stations.LPG','stations.ON','stations.PB95','stations.PB98')
    		->groupBy('stations.name')->get();
    	}
        
        $companies = DB::table('companies')->select('id','name','color')->get();
        
        return view('stations.index', ['stations' => $stations,'companies' => $companies]);
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
    	$this->validate($request, [
    			'name' => 'required|unique:stations|min:4',
    	]);
    	
    	$station = new Station;
    	$station->name = $request->input('name');
    	$station->latitude = $request->input('latitude');
    	$station->longtitude = $request->input('longtitude');
    	$station->LPG = $request->input('lpg');
    	$station->ON = $request->input('on');
    	$station->PB95 = $request->input('pb95');
    	$station->PB98 = $request->input('pb98');
    	$station->verify = $request->input('verify');
    	
    	$company = Company::find($request->input('company'));
    	
    	$company->stations()->save($station);
    	
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
    	
    	$this->validate($request, [
    			'name' => 'required|unique:stations|min:4',
    	]);
    	
    	$station = Station::find($id);
    	$station->name = $request->input('name');
    	$station->LPG = $request->input('lpg');
    	$station->ON = $request->input('on');
    	$station->PB95 = $request->input('pb95');
    	$station->PB98 = $request->input('pb98');
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
    public function verify($id)
    {
    	$station = Station::find($id);
    	$station->verify = 'true';
    	$station->save();
    	
    	return redirect()->back();
    }
	public function fetch(Request $request)
	{	
			Response::json('ok');	
	}
}
