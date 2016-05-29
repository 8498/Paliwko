@extends('layouts.app')

@section('content')

<div class="container">
	<div class="panel-body">
		<div id='map' class="col-md-6"></div>
	</div>
	
	<div class="panel panel-default">
    	<div class="panel-heading">Firmy</div>
    	<div class="panel-body">
        	<table class="table table-striped task-table">
        		<thead>
                	<th>Nazwa</th>
                	<th>Kolor</th>
            	</thead>
            	<tbody>
                	@foreach ($companies as $company)
                    	<tr>
                            <td class="table-text">
                            	<div>{{ $company->name }}</div>
                            </td>
                            
                            <td class="table-text">
                            	<div>{{ $company->color }}</div>
                            </td>
                            
                            <td>
                            	<a class="btn btn-small btn-info" href="{{ URL::to('companies/' . $company->id . '/edit') }}">Edytuj</a>
                            </td>                  
                           
                        </tr>
                        @endforeach
                </tbody>
        	</table>
        	
        	<!-- <a class="btn btn-small btn-info" href="{{ URL::to('stations/create') }}">Dodaj stacje</a>-->
        	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Dodaj firme</button>
        	
        </div>
    </div> 
</div>

<div id="myModal" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h4 class="modal-title">Dodaj firme</h4>
      		</div>
      		<div  class="modal-body">
        		<form class="form-horizontal" role="form" method="POST" action="{{ url('companies') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
						
						
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nazwa</label>

                            <div class="col-md-6">
                                <input type="name" class="form-control" name="name" >
                            </div>
                        </div>
                     
                     	<div class="form-group">
                            <label class="col-md-4 control-label">Kolor</label>

                            <div class="col-md-6">
                               <select class="form-control" name="color">
                               <option value="red">czerwony</option>
                               <option value="orange">pomaranczowy</option>
                               <option value="purple">fioletowy</option>
                               </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-plus"></i>Dodaj
                                </button>
                            </div>
                        </div>
                    </form>
      		</div>
      		<div class="modal-footer">
        		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i>Zamknij</button>
      		</div>
    	</div>
  	</div>
</div>

@endsection