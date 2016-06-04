<?php






/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => ['web']], function () {
	
Route::get('/', function () {
    return view('welcome');
});
	
Route::get('/map', function() {
	return view('map');
});

Route::get('stations/fetch',function(){
			if(Request::ajax())
			{
				$stations = DB::table('stations')->leftjoin('company_station','id','=','company_station.station_id')
				->leftjoin('companies','company_id','=','companies.id')->where('stations.verify','=','true')
				->select('stations.name','stations.id','stations.latitude','stations.longtitude','companies.name as company_name', 'companies.id as company_id', 'companies.color', 'stations.LPG as LPG', 'stations.ON as ON', 'stations.PB95 as PB95', 'stations.PB98 as PB98')
				->get();
				return $stations;
			}
		
});

/*Route::get('/getRequest', function(){
	if(Request::ajax())
	{
		return 'getRequest has loaded completely.';
	}
});*/
/*Route::post('/getCords', function() {
	$data = Input::all();
	if(Request::ajax())
	{
		$position = new Position();
		$position->latitude = $data['lat'];
		$position->longtitude = $data['lng'];
		$position->save();
		return Response::json(Request::all());
    	//return var_dump(Response::json());
	}
});*/

Route::resource('stations', 'StationsController');
	
Route::resource('users', 'UsersController');
	
Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['role:admin|mod']], function() {
	//Route::resource('users', 'UsersController');
	Route::resource('companies', 'CompaniesController');
	
	Route::get('/users','UsersController@index');
	
	Route::post('/users','UsersController@store');
	
	Route::get('/users/{id}','UsersController@show');
	
	Route::get('stations/{id}/verify', 'StationsController@verify');
	
	Route::get('users/{id}/giveModerator', 'UsersController@giveModerator');
	
	Route::get('users/{id}/takeModerator', 'UsersController@takeModerator');
});
/*Route::group(['middleware' => ['role:mod']], function() {
	Route::resource('users', 'UsersController');
});*/

});