@extends('Acme.layouts.template')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="active">Clients</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Clients</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">Clients List</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6">
                                <form method="get" action="{{ route('users')}}">
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
                                <table width="100%" class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th width="15%"></th>
                                        <th width="25%"><a href="{{ route('clients').'?page='.$page_number.'&search='.$search.'&order_by=email&sort='.$sort }}">Email</a></th>
                                        <th width="25%"><a href="{{ route('clients').'?page='.$page_number.'&search='.$search.'&order_by=first_name&sort='.$sort }}">First Name</a></th>
                                        <th width="25%"><a href="{{ route('clients').'?page='.$page_number.'&search='.$search.'&order_by=last_name&sort='.$sort }}">Last Name</a></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $row)
                                        <tr>
                                            <td style="text-align:center">
                                                <a title="View Profile of {{ $row->full_name  }}" href = "{{ route('client_profile', $row->id) }}">
                                                    <i class="fa fa-lg fa-user"></i>
                                                </a>&nbsp;

                                                @can('update_user')
                                                <a title="Edit Client {{ $row->full_name  }}" href = "{{ route('client_edit', $row->id) }}">
                                                    <i class="fa fa-lg fa-pencil-square-o"></i></a>&nbsp;
                                                @endcan
                                                @can('delete_user')
                                                <a title="Delete Client {{ $row->full_name  }}" href = "{{ route('client_destroy', $row->id) }}" onclick="return confirm('Are you sure you want to Delete this user?')">
                                                    <i class="fa fa-lg fa-user-times"></i>
                                                </a>&nbsp;
                                                @endcan
                                                        <!-- Modal -->
                                                <div id="{{ $row->id  }}_role_modal" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">

                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><label for="status">Assign Role</label></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('user_assign_role', $row->id) }}" method="post">
                                                                    <select name="role" id="role" class="form-control">
                                                                        <option value="" selected disabled>-Choose Role-</option>
                                                                        @foreach(App\Role::all() as $role)

                                                                            <option value="{{ $role->id  }}" @if($row->Role()->first()->id == $role->id))) selected @endif>{{ $role->name }}</option>
                                                                        @endforeach
                                                                    </select>

                                                                    <br/>
                                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                                    {!! csrf_field() !!}
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->first_name  }}</td>
                                            <td>{{ $row->last_name  }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                                @if($users->count() == 0)
                                    <div style="text-align:center; color:#333; font-size:18px">No records to show</div>
                                    @if($search)
                                        <div style="text-align:center; color:#333; font-size:18px">for {{ $search }}</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


