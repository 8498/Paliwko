@extends('layouts.app')

@section('content')
<div class="container">
	<div class="jumbotron text-center">
    	<h2>{{ $user->name }}</h2>
        <p>
        	<strong>Nazwa:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}
        </p>
	</div>
	<div class="list-group text-center">
	<a href="{{ URL::to('users/' . $user->id . '/edit') }}" class="list-group-item">Zmien adres email</a>
	<form class="list-group-item" method="POST" action="{{ url('users/'.$user->id) }}">
                    	<input type="hidden" name="_method" value="DELETE">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    	<button type="submit" class="btn btn-primary">Usun konto</button>
                    </form>
	</div>
</div>
@endsection