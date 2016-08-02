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
<div claass="row">
	<div class="col-sm-6">
		<a href="{{ route('flags_create')}}" class="btn btn-primary"><i class="fa fa-flag"></i> Add Flag</a>
	</div>
	<div class="col-sm-6">
        <form method="get" action="{{ route('flags')}}">
            <div class="search form-group" style="float:right">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                    <input type="text" class="search-form form-control" placeholder="Search" name="search" aria-describedby="basic-addon1" value="{{ $search }}">
                    <span class="input-group-btn clearer">
                        <button class="btn btn-primary" type="button" style="border:none; background-color:transparent; z-index:999; margin-left:-35px; font-size:10px"><a href="{{ route('users')}}">X</a></button>
                    </span>
                    <span class="input-group-btn">
                        <button class="btn btn-secondary" type="submit">Go</button>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
	<div class="col-sm-12">
		{{ $flags->render() }}
	</div>
</div>
<div class="row">
	<table width="100%" class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="15%"></th>
				<th width="15%"><a href="{{ route('flags').'?page='.$page_number.'&search='.$search.'&order_by=flag_type&sort='.$sort}}">Flag Type</a></th>
				<th width="50%"><a href="{{ route('flags').'?page='.$page_number.'&search='.$search.'&order_by=description&sort='.$sort}}">Description</a></th>
				<th width="20%"><a href="{{ route('flags').'?page='.$page_number.'&search='.$search.'&order_by=range&sort='.$sort}}">Range</a></th>
			</tr>
		</thead>
		<tbody>
			@foreach($flags as $flag)
			<tr>
				<td class="dropdown">
					<button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-toggle="dropdown">
						Options<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="{{ route('flags_edit', $flag->id)}}">Edit</a></li>
						<li><a class="delete_confirmation" href="{{ route('flags_delete', $flag->id)}}">Delete</a></li>
					</ul>
				</td>
				<td><span class="chart-title {{ ($flag->flag_type == 'Yellow')? 'yellow' : 'red'}}-flag-title">
                      <i class="fa fa-flag fa-lg"></i>&nbsp;
                  	</span>
                  	{{$flag->flag_type}}
                 </td>
				<td>{{$flag->description}}</td>
				<td>{{$flag->range}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	
	@if($flags->count() == 0)
        <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
        @if($search)
            <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
        @endif
    @endif
</div>
@endsection
@section('scripts')
    <script src="{{ asset("js/jquery-confirm/js/jquery-confirm.js") }}"></script>
    <script>
       $('.delete_confirmation').on('click',function(){
           confirm('Are you sure you want to delete this Flag?');
       });
    </script>
@stop