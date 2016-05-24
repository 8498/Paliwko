@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
    	<div class="panel-heading">Users</div>
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
                            
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('stations/' . $station->id . '/edit') }}">Edit</a>
                            </td>                  
                           
                        </tr>
                        @endforeach
                </tbody>
        	</table>
        	<a class="btn btn-small btn-info" href="{{ URL::to('stations/create') }}">Dodaj stacje</a>
        </div>
    </div> 
</div>

@endsection