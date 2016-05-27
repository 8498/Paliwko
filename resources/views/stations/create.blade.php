@extends('layouts.app')

@section('head')
<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script src='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.js'></script>


<link href='https://api.mapbox.com/mapbox.js/v2.4.0/mapbox.css' rel='stylesheet' />

<style>
	 #map1 { position:absolute; top:0; bottom:0; width:100%; }
	 #map { height: 500px; width: 1200px; }
</style>
@endsection

@section('content')

<div class="container">

	<h2>Dodaj Stacje</h2>
					<form class="form-horizontal" role="form" method="POST" action="{{ url('stations') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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

@endsection