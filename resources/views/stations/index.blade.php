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
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-body">
				<form class="form-horizontal">
				
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label">Firma</label>
							
							<select id="company" class="form-control">
								<option value="wszystkie">Wszystkie</option>
								@foreach ($companies as $company)
	  							<option value="{{ $company->name }}">{{ $company->name }}</option>
	  							@endforeach
							</select>
						
							<button id="filtr" type="button" class="btn btn-primary">
                                   Pokaz
                            </button>
						</div>
					</div>
				</form>
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
});

$.ajaxSetup({
	 headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 }
	});

document.getElementById("filtr").addEventListener("click", filtrfun);
function filtrfun()
{
	function getColor(color)
	{
		return {icon: L.AwesomeMarkers.icon({icon: 'flag',  prefix: 'glyphicon',markerColor: color})};
	}
L.mapbox.accessToken = 'pk.eyJ1IjoicGxveHFxIiwiYSI6ImNpbzh3czQzcTAwOHh1c2tuejFjMHFzNWEifQ.e7p65gm0vPLir5gtCFWJZQ';
// Replace 'mapbox.streets' with your map id.
var mapboxTiles = L.tileLayer('https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=' + L.mapbox.accessToken, {
    attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});
var map = L.map('map')
    .addLayer(mapboxTiles)
	
	map.locate({setView: true, maxZoom: 16});//watch:true
	
	var markerUser = null;

	var circle = null;

	var lat2 = null;

	var lng2 = null;

	var latlngUser = null;

	map.on('locationfound', function (e) {

		var radius = e.accuracy / 4;
		
		if(markerUser !== null && circle !== null) {
			map.removeLayer(markerUser);
			map.removeLayer(circle);
			}
			markerUser = L.marker(e.latlng).addTo(map);
			lat2 = e.latlng.lat;
			lng2 = e.latlng.lng;
			latlngUser = e.latlng;
	
			circle = L.circle(e.latlng, radius).addTo(map);

			L.easyButton('fa-crosshairs fa-lg', function(btn, map){
				map.setView(e.latlng);
			}).addTo(map);
});

	
	
	/*$(document).ready(function() 
			{
		  $.ajax({
	            type: "GET",
	            url: '/stations/fetch',
	            datatype: "JSON",   
	            success: function( response ) {
	            	console.log(Object.keys(response).length);
	            	response.forEach(function(data) {
	            	      var stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name);
	            	      stationMarker.on('mouseover',function (e){
		            	      this.openPopup();
		            	      });
	            	      stationMarker.on('mouseout',function (e){
		            	      this.closePopup();
		            	      });
	            	      stationMarker.on('click', function (e) {
	            	    	  L.Routing.control({
	            	    		  waypoints: [
	            	    		    L.latLng(e.latlng),
	            	    		    L.latLng(latlngUser)
	            	    		  ],
	            	    		  draggableWaypoints: false,
	            	    		  addWaypoints: false,
	            	    		  reverseWaypoints: true,
	            	    		  show: false
	            	    		}).addTo(map);
	            	      });
	            	      stationMarker.addTo(map);
	            	      console.log(data);
	            	   });
	            }
	        });
	        console.log(typeof(id));
	});	*/

	

		var stationMarker = null;
		console.log(document.getElementById("company").value);
		$.ajax({
            type: "GET",
            url: '/stations/fetch',
            datatype: "JSON",   
            success: function( response ) {
            	console.log(Object.keys(response).length);
            	response.forEach(function(data) {

					console.log(data.company_name);
					console.log(document.getElementById("company").value);
					if(data.company_name === document.getElementById("company").value){
						console.log("tak");
						stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name);
						stationMarker.on('mouseover',function (e){
		            	      this.openPopup();
		            	      });
	            	      stationMarker.on('mouseout',function (e){
		            	      this.closePopup();
		            	      });
	            	      stationMarker.on('click', function (e) {
	            	    	  L.Routing.control({
	            	    		  waypoints: [
	            	    		    L.latLng(e.latlng),
	            	    		    L.latLng(latlngUser)
	            	    		  ],
	            	    		  draggableWaypoints: false,
	            	    		  addWaypoints: false,
	            	    		  reverseWaypoints: true,
	            	    		  show: false
	            	    		}).addTo(map);
	            	      });
	            	      stationMarker.addTo(map);
	            	      console.log(data);
						}
					else if("wszystkie" === document.getElementById("company").value){
						console.log("nie");
						stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name);
						stationMarker.on('mouseover',function (e){
		            	      this.openPopup();
		            	      });
	            	      stationMarker.on('mouseout',function (e){
		            	      this.closePopup();
		            	      });
	            	      stationMarker.on('click', function (e) {
	            	    	  L.Routing.control({
	            	    		  waypoints: [
	            	    		    L.latLng(e.latlng),
	            	    		    L.latLng(latlngUser)
	            	    		  ],
	            	    		  draggableWaypoints: false,
	            	    		  addWaypoints: false,
	            	    		  reverseWaypoints: true,
	            	    		  show: false
	            	    		}).addTo(map);
	            	      });
	            	      stationMarker.addTo(map);
	            	      console.log(data);
						}
						
                	/*if(document.getElementById("company").value = "wszyscy")
                	{
                		stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name);
                    }
                	else if(data.company_name = document.getElementById("company").value)
                	{
                		stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name);
                	}*/
            	      
            	      
            	   });
            }
        });
        console.log(typeof(id));
	
	
	function onLocationError(e) {
    alert(e.message);
	}
	
	map.on('locationerror', onLocationError);
		
		var kord = new Vue({
			el:'#kord',
			data:{
				latitude: '',
				longtitude: ''}
		})

		var marker = null;
		console.log(marker);
		function sendKords(e) { 
			kord.latitude = e.latlng.lat;
			kord.longtitude = e.latlng.lng;
			if(marker !== null)
			{
				map.removeLayer(marker);
				console.log(marker.getLatLng());
			}
	        marker = L.marker(e.latlng,{icon: L.AwesomeMarkers.icon({icon: 'star',  prefix: 'glyphicon',markerColor: 'cadetblue'})}).addTo(map);
	        $('#addStation').prop('disabled', false);
		}
		
		map.on('click', sendKords);
}
</script>

@endsection