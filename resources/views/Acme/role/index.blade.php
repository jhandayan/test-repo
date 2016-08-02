@extends('Acme.layouts.template')
@section('title', 'Roles')


@section('content')
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="active">Roles</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <h1>Roles</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default bootstrap-admin-no-table-panel">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel-heading">
                    <div class="text-muted bootstrap-admin-box-title">Roles List</div>
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
                    <div class="col-sm-6">
                        @can("add_role")<a class="btn btn-primary" title="Add a Role" href="{{ route('role_add')}}"><i class="fa fa-plus"></i> &nbsp;Add Role</a>@endcan
                    </div>
                    <div class="col-sm-6">
                        <form method="get" action="{{ route('role_list')}}">
                            <div class="search form-group" style="float:right">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                                    <input type="text" class="search-form form-control" placeholder="Search" name="search" aria-describedby="basic-addon1" value="{{ $search }}">
                        <span class="input-group-btn clearer">
                            <button class="btn btn-primary" type="button" style="border:none; background-color:transparent; z-index:999; margin-left:-35px; font-size:10px"><a href="{{ route('role_list') }}">X</a></button>
                        </span>
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">Go</button>
                        </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th><a href="{{ route('role_list').'?page='.$page_number.'&search='.$search.'&order_by=name&sort='.$sort }}">Name</a></th>
                                <th><a href="{{ route('role_list').'?page='.$page_number.'&search='.$search.'&order_by=label&sort='.$sort }}">Role</a></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role as $row)
                                <tr>
                                    <td>@can("update_role")<a href="{{ route('role_edit', $row->id)}}"><i class="fa fa-lg fa-pencil-square-o"></i></a>@endcan | @can("delete_role")<a href="{{ route('role_delete', $row->id) }}" onclick="return confirm('Are you sure you want to Delete this role?')"><i class="fa fa-lg fa-times"></i></a>@endcan </td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->label }}</td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($role->count() == 0)
                            <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                            @if($search)
                                <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                            @endif
                        @endif
                    </div>
                    {!! str_replace('/?', '?', $role->render()) !!}
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
