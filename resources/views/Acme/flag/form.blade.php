@extends('Acme.layouts.template')
@section('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/action_steps.css') }}">
@stop
@section('content')
@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      {{ Session::get('message') }}
  </div>
@elseif(count($errors) > 0)
  @foreach ($errors->all() as $error)
      <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <li style="list-style:none">{{ $error }}</li>
      </div>
  @endforeach
@endif
<div class="row">
	<form class="form" method="post" action="{{ route('flags_store') }}">
      <div class="panel panel-primary">
      	<div class="panel-heading"><i class="fa fa-flag fa-lg"></i>&nbsp;Flag Details</div>
      	<div class="panel-body">
      		<fieldset>
      			<div class="row">
      				<div class="col-sm-3">
      					<label>Flag Type</label>
      				</div>
      				<div class="col-sm-9">
                                    <div class="col-sm-4">
                                          <label>
                                                <input type="radio" name="flag_type" value="1" {{ ($flag_type == 'Red') ? 'checked="checked' : ''}}>
                                                <span class="chart-title red-flag-title">
                                                    <i class="fa fa-flag fa-lg"></i>&nbsp; Red Flags
                                                </span>
                                          </label>
                                    </div>
                                    <div class="col-sm-4">
                                          <label>
                                                <input type="radio" name="flag_type" value="2" {{ ($flag_type == 'Yellow') ? 'checked="checked' : ''}}>
                                                <span class="chart-title yellow-flag-title">
                                                    <i class="fa fa-flag fa-lg"></i>&nbsp; Yellow Flags
                                                </span>
                                          </label>
                                    </div>
                                    <div class="col-sm-4">
                                    </div>
      				</div>
      			</div>
      			&nbsp;
      			<div class="row">
      				<div class="col-sm-3">
      					<label>Description</label>
      				</div>
      				<div class="col-sm-9">
                                    <textarea class="form-control" name="description" placeholder="Add Description" rows="5">{{ $description }}</textarea>
      				</div>
      			</div>
      			&nbsp;
      			<div class="row">
      				<div class="col-sm-3">
      					<label>Range</label>
      				</div>
      				<div class="col-sm-9">
      					<input type="number" class="form-control" name="range" value="{{ $range }}">
      				</div>
      			</div>
                        {!! csrf_field() !!}
      			<input type="submit" style="margin:15px" class="btn btn-success pull-right" value="Submit">
                        <a href="{{ route('flags') }}">
                              <input type="button" style="margin-top:15px" class="btn btn-danger pull-right" value="Cancel">
                        </a>
      		</fieldset>
      	</div>
      </div>
	</form>
</div>
@endsection