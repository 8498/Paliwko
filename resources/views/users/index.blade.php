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
                	<th>Password</th>
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
                            	<div>{{ $user->password }}</div>
                            </td>

                            <td>
                            	<form action="{{ url('user/'.$user->id) }}" method="POST">
            						{{ csrf_field() }}
            						{{ method_field('Edit') }}

            						<button type="submit" id="edit-user-{{ $user->id }}" class="btn btn-danger">
                					<i class="fa fa-btn fa-trash"></i>Edit
            						</button>
        						</form>
                            </td>
                        </tr>
                        @endforeach
                </tbody>
        	</table>
        </div>
    </div> 
</div>

@endsection
