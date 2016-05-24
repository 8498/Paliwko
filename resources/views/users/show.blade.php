@extends('layouts.app')

@section('content')
<div class="jumbotron text-center">
        <h2>{{ $user->name }}</h2>
        <p>
        	<strong>Name:</strong> {{ $user->name }}<br>
            <strong>Email:</strong> {{ $user->email }}
        </p>
</div>
@endsection