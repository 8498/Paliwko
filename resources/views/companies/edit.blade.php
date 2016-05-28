@extends('layouts.app')

@section('content')

<div class="container">

	<h2>Edytuj Firme {{ $company->name }}</h2>
					<form class="form-horizontal" role="form" method="POST" action="{{ url('companies/'.$company->id) }}">
                        <input type="hidden" name="_method" value="PUT">
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
                                    <i class="fa fa-btn fa-sign-in"></i>Edytuj
                                </button>
                            </div>
                        </div>
                    </form>
                    <form method="POST" action="{{ url('companies/'.$company->id) }}">
                    	<input type="hidden" name="_method" value="DELETE">
                    	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                    	<button type="submit" class="btn btn-primary">
                    		<i class="fa fa-btn fa-sign-in"></i>DELETE
                    	</button>
                    </form>
</div>

@endsection