@extends('layouts.app')

@section('content')
<div class="container">
	<div class="panel panel-default">
    	<div class="panel-heading">Users</div>
    	<div class="panel-body">
        	<table class="table table-striped task-table">
        		<thead>
                	<th>Nazwa</th>
                	<th>Email</th>
                	<th>Uprawnienia</th>
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
                            <td class="table-text">
                            	<div>{{ $user->role_name }}</div>
                            </td>
							@role('admin')
                            @if($user->role_name == 'sub')
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('users/' . $user->id . '/giveModerator') }}">Nadanie Moderatora<i class="glyphicon glyphicon-arrow-up"></i></a>
                            </td>
                            @elseif($user->role_name == 'mod')
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('users/' . $user->id . '/takeModerator') }}">Odebranie Moderatora<i class="glyphicon glyphicon-arrow-down"></i></a>
                            </td>
                            @endif
                            @endrole
                        </tr>
                        @endforeach
                </tbody>
        	</table>
        </div>
    </div> 
</div>
@endsection
