$.ajaxSetup({
	 headers: {
		 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	 }
	});

document.getElementById("filtr").addEventListener("click", filtrfun);
function filtrfun()
{	
	$("#filtrModal").modal("hide");
	function getColor(color)
	{
		return {icon: L.AwesomeMarkers.icon({icon: 'flag',  prefix: 'glyphicon',markerColor: color})};
	}
L.mapbox.accessToken = 'pk.eyJ1IjoicGxveHFxIiwiYSI6ImNpbzh3czQzcTAwOHh1c2tuejFjMHFzNWEifQ.e7p65gm0vPLir5gtCFWJZQ';
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
						stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name+"<br>Ceny paliw:<br>LPG: "+data.LPG+"<br>ON:"+data.ON+"<br>PB95:"+data.PB95+"<br>PB98:"+data.PB98);
						console.log(data.slpg);
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
						stationMarker = L.marker([data.latitude,data.longtitude],getColor(data.color)).bindPopup("nazwa: "+data.name+"<br>"+" firma: "+data.company_name+"<br>Ceny paliw:<br>LPG: "+data.LPG+"<br>ON:"+data.ON+"<br>PB95:"+data.PB95+"<br>PB98:"+data.PB98);
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