@extends('layouts/app')

@section('content')

<div class="container">
	<div class="panel panel-default">
    	<div class="panel-heading">Users</div>
    	<div class="panel-body">
        	<table class="table table-striped task-table">
        		<thead>
                	<th>Name</th>
                	<th>Email</th>
            	</thead>
            	<tbody>
                	@foreach ($users as $user)
                    	<tr>
                        	<!-- Task Name -->
                            <td class="table-text">
                            	<div>{{ $user->name }}</div>
                            </td>
                            
                            <td class="table-text">
                            	<div>{{ $user->email }}</div>
                            </td>
							@role('admin')
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('users/' . $user->id . '/edit') }}">Moderator</a>
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                </tbody>
        	</table>
        </div>
    </div> 
</div>

@endsection
