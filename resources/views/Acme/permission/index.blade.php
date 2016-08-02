@extends('Acme.layouts.template')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="active">Permission</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Permissions</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Permissions List</div>
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
                            @can("add_permission")<a title="Add a New Permission" class="btn btn-primary" href="{{ route('permission_add')}}"><i class="fa fa-plus"></i> &nbsp;Add Permission</a>@endcan
                        </div>
                        <div class="col-sm-6">
                            <form method="get" action="{{ route('permission_list')}}">
                                <div class="search form-group" style="float:right">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                                        <input type="text" class="search-form form-control" placeholder="Search" name="search" aria-describedby="basic-addon1" value="{{ $search }}">
                            <span class="input-group-btn clearer">
                                <button class="btn btn-primary" type="button" style="border:none; color:#333; background-color:transparent; z-index:999; margin-left:-35px; font-size:10px"><a href="{{ route('permission_list') }}">X</a></button>
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
                                    <th><a href="{{ route('permission_list').'?page='.$page_number.'&search='.$search.'&order_by=name&sort='.$sort }}">Name</a></th>
                                    <th><a href="{{ route('permission_list').'?page='.$page_number.'&search='.$search.'&order_by=label&sort='.$sort }}">Description</a></th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permission as $row)
                                    <tr>
                                        <td>@can("update_permission")<a href="{{ route('permission_edit', $row->id)}}"><i class="fa fa-lg fa-pencil-square-o"></i></a>@endcan | @can("delete_permission")<a href="{{ route('permission_delete', $row->id) }}" onclick="return confirm('Are you sure you want to Delete this permission?')"><i class="fa fa-lg fa-times"></i></a>@endcan </td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->label }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            @if($permission->count() == 0)
                                <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                                @if($search)
                                    <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                                @endif
                            @endif
                        </div>
                        {!! str_replace('/?', '?', $permission->render()) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection