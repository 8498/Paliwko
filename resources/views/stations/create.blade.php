@extends('layouts.app')

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