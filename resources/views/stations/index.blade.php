@extends('layouts.app')

@section('head')
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.24/vue.js'></script>

<link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />

<style>
	 #map1 { position:absolute; top:0; bottom:0; width:100%; }
	 #map { height: 500px; width: 1200px; }
</style>
@endsection

@section('content')
<input type="submit" value="Submit" id="x"/>
<div id="messages"></div>
<div class="container">
	<div class="panel-body">
		<div id='map' class="col-md-6"></div>
	</div>
	
	<div class="panel panel-default">
    	<div class="panel-heading">Stations</div>
    	<div class="panel-body">
        	<table class="table table-striped task-table">
        		<thead>
                	<th>Name</th>
            	</thead>
            	<tbody>
                	@foreach ($stations as $station)
                    	<tr>
                            <td class="table-text">
                            	<div>{{ $station->name }}</div>
                            </td>
                            
                            @if(Auth::check())
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('stations/' . $station->id . '/edit') }}">Edit</a>
                            </td>                  
                           @endif
                        </tr>
                        @endforeach
                </tbody>
        	</table>
        	@if(Auth::check())
        	<!-- <a class="btn btn-small btn-info" href="{{ URL::to('stations/create') }}">Dodaj stacje</a>-->
        	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Dodaj stacje</button>
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
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="name" class="form-control" name="name" >
                                
                            </div>
                        </div>
                     

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Dodaj
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
$.ajaxSetup({
	 headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 }
	});

L.mapbox.accessToken = 'pk.eyJ1IjoicGxveHFxIiwiYSI6ImNpbzh3czQzcTAwOHh1c2tuejFjMHFzNWEifQ.e7p65gm0vPLir5gtCFWJZQ';
// Replace 'mapbox.streets' with your map id.
var mapboxTiles = L.tileLayer('https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=' + L.mapbox.accessToken, {
    attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});

var map = L.map('map')
    .addLayer(mapboxTiles)
	
	map.locate({setView: true,maxZoom: 16});//watch:true

	$(document).ready(function() {
		  $.ajax({
	            type: "GET",
	            url: '/stations/fetch',
	            datatype: "JSON",   
	            success: function( response ) {
	            	console.log(Object.keys(response).length);
	            	response.forEach(function(data) {
	            	      L.marker([data.latitude,data.longtitude]).bindPopup(data.name).addTo(map);
	            	      console.log(data);
	            	   });
	            }
	        });
	        console.log(typeof(id));
	});
	
	var markerUser = null;

	var circle = null;

	var lat2 = null;

	var lng2 = null;

	map.on('locationfound', function (e) {

		var radius = e.accuracy / 3;
		
		if(markerUser !== null && circle !== null) {
			map.removeLayer(markerUser);
			map.removeLayer(circle);
			}
			markerUser = L.marker(e.latlng).addTo(map);

			lat2 = e.latlng.lat;
			lng2 = e.latlng.lng;
									

		/* var dataString = "latitude="+lat+"&lng="+lng;

			$.ajax({
				method: "POST",
				url: "getCords",
				data: dataString,
				succes: function(data){
					console.log(data);
					},
				error: function(data){
					console.log(data);
				}
			}); */
	
			circle = L.circle(e.latlng, radius).addTo(map);
});
	
	function onLocationError(e) {
    alert(e.message);
	}

	map.on('locationerror', onLocationError);

	$(document).ready(function (){
		$('#getRequest').click(function(){
		$.get('getRequest', function (data){
			console.log(data);
			});
		});
		});
	
		/*map.on('click', function(e) {
		var latitude = e.latlng.lat;
		var longtitude = e.latlng.lng;
		var kord = new Vue({
			el:'#kord',
			data:{
				lat: latitude,
				lng: longtitude},
				created: function () {
				    // `this` points to the vm instance
				    console.log('lat: ' + latitude + ' long: ' + longtitude)
				  }
		})
	});*/

		/*function sendKords(e) { 
			var lat = e.latlng.lat;
			var lng = e.latlng.lng;
			var kord1 = new Vue({
				el:'#kord',
				data:{
					latitude: lat,
					longtitude: lng},
					created: function () {
					    // `this` points to the vm instance
					    console.log('lat: ' + lat + ' long: ' + lng)
					  }
			})
			}
	
		map.on('click', sendKords);*/

		var kord = new Vue({
			el:'#kord',
			data:{
				latitude: '',
				longtitude: ''}/*,
				created: function () {
				    // `this` points to the vm instance
				    console.log('lat: ' + latitude + ' long: ' + longtitude)
				  }*/
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
	        marker = L.marker(e.latlng).addTo(map);
		}
		
		
		map.on('click', sendKords);
	/*function onClick(e) { 
			var latitude = e.latlng.lat;
			var longtitude = e.latlng.lng;
			var kord = new Vue({
				el:'#kord',
				data:{
					lat: latitude,
					lng: longtitude}
			})}
	map.on('click', onClick);*/
	
	/*new Vue({

	    ready: function() {

	      var resource = this.$resource('stations{/id}');

	      // get item
	      resource.get({id: 1}).then(function (response) {
	          this.$set('item', response.item)
	          console.log(response.item);
	      });
	     
	    }

	})*/
</script>

@endsection