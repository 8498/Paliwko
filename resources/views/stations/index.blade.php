@extends('layouts.app')

@section('head')
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>

<link rel="stylesheet" href="leaflet-routing-machine.css" />

<script src="leaflet-routing-machine.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.js'></script>

<link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />

<script src="https://raw.githubusercontent.com/CliffCloud/Leaflet.EasyButton/master/src/easy-button.js"></script>

<link href='https://raw.githubusercontent.com/CliffCloud/Leaflet.EasyButton/master/src/easy-button.css' rel='stylesheet' />

<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css">

<link rel="stylesheet" href="http://watson.lennardvoogdt.nl/Leaflet.awesome-markers/dist/leaflet.awesome-markers.css">

<script src="http://watson.lennardvoogdt.nl/Leaflet.awesome-markers/dist/leaflet.awesome-markers.js"></script>

<style>
	 #map1 { position:absolute; top:0; bottom:0; width:100%; }
	 #map { height: 500px; width: 1200px; }
</style>
@endsection

@section('content')
<div class="container">

<div id="filtrModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Filtr</h4>
      		</div>
      		<div  class="modal-body">
							<label class="col-md-4 control-label">Wybierz jakiej firmy stacje chcesz zobaczyc:</label>
							
							<select id="company" class="form-control">
								<option value="wszystkie">Wszystkie</option>
								@foreach ($companies as $company)
	  							<option value="{{ $company->name }}">{{ $company->name }}</option>
	  							@endforeach
							</select>
							
							<div class="modal-footer">
								<button id="filtr" type="button" class="btn btn-primary">
                                   Pokaz
                            	</button>
                            </div>
      		</div>
		</div>
	</div>
</div>

	<div class="panel panel-default">
    	<div class="panel-heading">Legenda</div>
    		<div class="panel-body">
    			@foreach ($companies as $company)
    			<p style="color:{{ $company->color }}">{{ $company->name }}</p>
    			@endforeach
    	</div>
    </div>
	<div class="panel-body">
		<div id='map' class="col-md-6"></div>
	</div>
	
	<div class="panel panel-default">
    	<div class="panel-heading">Stacje</div>
    	<div class="panel-body">
    		@role('admin' , 'mod')
        	<table class="table table-striped task-table">
        		<thead>
                	<th>Nazwa</th>
                	<th>Firma</th>
                	<th>LPG</th>
                	<th>ON</th>
                	<th>PB95</th>
                	<th>PB98</th>
            	</thead>
            	<tbody>
                	@foreach ($stations as $station)
                    	<tr>
                            <td class="table-text">
                            	<div>{{ $station->name }}</div>
                            </td>
                            
                            <td class="table-text">
                            	<div>{{ $station->company_name }}</div>
                            </td>
                            <td class="table-text">
                            	<div>{{ $station->LPG }}</div>
                            </td>
                            <td class="table-text">
                            	<div>{{ $station->ON }}</div>
                            </td>
                            <td class="table-text">
                            	<div>{{ $station->PB95 }}</div>
                            </td>
                            <td class="table-text">
                            	<div>{{ $station->PB98 }}</div>
                            </td>
                            
                            @if(Auth::check())
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('stations/' . $station->id . '/edit') }}">Edytuj</a>
                            </td>  
    						@if($station->verify == 'false')
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('stations/' . $station->id . '/verify') }}">Verify</a>
                            </td> 
                            @endif         
                           @endif
                        </tr>
                        @endforeach
                	</tbody>
        		</table>
        		@endrole
        		@if(Auth::check())
        	<!-- <a class="btn btn-small btn-info" href="{{ URL::to('stations/create') }}">Dodaj stacje</a>-->
        		<button id="addStation" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" >Dodaj stacje</button>
        		@endif
        </div>
    </div>
	</div>

<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Dodaj stacje</h4>
      		</div>
      		<div  class="modal-body">
        		<form class="form-horizontal" role="form" method="POST" action="{{ url('stations') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div id="kord">
                        <input type="hidden" v-model="latitude" name="latitude">
            			<input type="hidden" v-model="longtitude" name="longtitude">
                        </div>
						
						
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nazwa</label>

                            <div class="col-md-6">
                                <input type="name" class="form-control" name="name" >
                                
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            
                            <label class="col-md-4 control-label">LPG</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="lpg" >
                            </div>
                            
                            <label class="col-md-4 control-label">ON</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="on" >
                            </div>
                            
                            <label class="col-md-4 control-label">Pb95</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="pb95" >
                            </div>
                            
                            <label class="col-md-4 control-label">Pb98</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="pb98" >
                            </div>
                            
                            <label class="col-md-4 control-label">Firma</label>
                            
                            <div class="col-md-6">
                                <select class="form-control" name="company">
                                	@foreach ($companies as $company)
  									<option value="{{ $company->id }}">{{ $company->name }}</option>
  									@endforeach
								</select>
                            </div>
                            @role('admin', 'mod')
                            <input type="hidden" class="form-control" name="verify" value="true" >
                            @endrole
                            @role('sub')
                            <input type="hidden" class="form-control" name="verify" value="false">
                            @endrole
                        </div>
                     

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-plus"></i>Dodaj
                                </button>
                            </div>
                        </div>
                    </form>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Zamknij</button>
      		</div>
    	</div>
  	</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
    $('#addStation').prop('disabled', true);
    $("#filtrModal").modal({backdrop: false});
});
</script>

<script src="map-script.js"></script>

@endsection