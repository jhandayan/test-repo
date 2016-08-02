@extends('Acme.layouts.template')
@section('content')
	<div class="row">
		<div class="col-md-12">
			<ul class="breadcrumb">
				<li><a href="{{ route('dashboard') }}">Dashboard</a></li>
				<li><a href="{{ route('permission_list') }}">Permissions</a></li>
				<li class="active">{{ $header }}</li>
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1>{{ $header }}</h1>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default bootstrap-admin-no-table-panel">
				<div class="panel panel-default bootstrap-admin-no-table-panel">
					<div class="panel-heading">
						<div class="text-muted bootstrap-admin-box-title">{{ $header }}</div>
					</div>
					<div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
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
						<form action="{{ $action }}" method="post">
							<input class="form-control" name="name" placeholder="Permission Name" value="{{ (isset($permission->name)?$permission->name : old('name')) }}">
							<br>
							<input class="form-control" name="label" placeholder="Permission Description" value="{{ (isset($permission->label)?$permission->label : old('label')) }}">
							<br>
							{!! csrf_field() !!}
							<button type="submit" class="btn btn-lg btn-primary" >{{ $header }}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection