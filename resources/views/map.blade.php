@extends('layouts.app')

@section('head')
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

<script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>

<link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />

<style>
	 #map1 { position:absolute; top:0; bottom:0; width:100%; }
	 #map { height: 500px; width: 1200px; }
</style>
@endsection

@section('content')
<div class="container">
    	<div id='map' class="col-md-6"></div>
</div>

<script type="text/javascript">
L.mapbox.accessToken = 'pk.eyJ1IjoicGxveHFxIiwiYSI6ImNpbzh3czQzcTAwOHh1c2tuejFjMHFzNWEifQ.e7p65gm0vPLir5gtCFWJZQ';
// Replace 'mapbox.streets' with your map id.
var mapboxTiles = L.tileLayer('https://api.mapbox.com/v4/mapbox.streets/{z}/{x}/{y}.png?access_token=' + L.mapbox.accessToken, {
    attribution: '© <a href="https://www.mapbox.com/map-feedback/">Mapbox</a> © <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
});

var map = L.map('map')
    .addLayer(mapboxTiles)
	
	map.locate({setView: true, maxZoom: 16});
	
	function onLocationFound(e) {
    var radius = e.accuracy / 3;

    L.marker(e.latlng).addTo(map)
        .bindPopup("You are within " + radius + " meters from this point").openPopup();

    L.circle(e.latlng, radius).addTo(map);
	}
	
	map.on('locationfound', onLocationFound);
	
	function onLocationError(e) {
    alert(e.message);
    location.reload();
	}

	map.on('locationerror', onLocationError);
</script>

@endsection
