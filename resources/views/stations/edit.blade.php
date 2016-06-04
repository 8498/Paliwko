@extends('layouts.app')

@section('content')

<div class="container">

	<h2>Edytuj Stacje {{ $station->name }}</h2>
					<form class="form-horizontal" role="form" method="POST" action="{{ url('stations/'.$station->id) }}">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                        </div>
                     
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Edytuj
                                </button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ url('stations/'.$station->id) }}">
                    	<input type="hidden" name="_method" value="DELETE">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    	<button type="submit" class="btn btn-primary">
                    		<i class="glyphicon glyphicon-trash"></i>Usun
                    	</button>
                    </form>
</div>

@endsection