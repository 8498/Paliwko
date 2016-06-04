@extends('layouts.app')

@section('content')
<div class="container">
	<form class="form-horizontal" role="form" method="POST" action="{{ URL::to('users/'.$user->id) }}">
		<input type="hidden" name="_method" value="PUT">
    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="form-group">
			<label for="email">Nowy email:</label>
			<input type="email" class="form-control" name="email" >
			
			@if ($errors->has('email'))
            	<span class="help-block">
                	<strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
		</div>
		<div class="form-group">
			<label for="password">Twoje haslo:</label>
			<input type="password" class="form-control" name="password" >
		</div>
		<button type="submit" class="btn btn-default">Zmien</button>
	</form>
</div>
@endsection
