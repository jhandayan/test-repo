
@extends('Acme.layouts.template')
@section('content')

<style type="text/css">
input[type="file"] {
    display: none;
}
.custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
.uneditable-input {
    padding: 6px 12px;
    min-width: 206px;
    font-size: 14px;
    font-weight: normal;
    height: 34px;
    color: #333;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    }
.inline-file
{
    position:absolute;
    top: 0;
    right:0;
    margin-right: 14px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('users') }}">Users</a></li>
            <li class="active">@if($action_name == 'Add')Add User @else Edit {{ $first_name  }} @endif</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="page-header">
            <h1>@if($action_name == 'Add')Add User @else Edit {{ $first_name  }} @endif</h1>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default bootstrap-admin-no-table-panel">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel-heading">
                    <div class="text-muted bootstrap-admin-box-title">@if($action_name == 'Add')Add User @else Edit {{ $first_name  }} @endif</div>
                </div>
                <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                    <div class="row">
                        <div class="col-md-12">
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
                            <form id="user_form" role="form" action="{{ $action }}" method="post" class="form idealforms">
                                <div class="row">
                                    <div class="col-sm-3">
                                        &nbsp;
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-primary">
                                            <div class="panel-heading"><i class="fa fa-user"></i>&nbsp;</span>Personal Details</div>
                                            <div class="panel-body">
                                                <fieldset>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="pull-right">Photo</label>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <img src="{{ asset('images/default_user.png') }}" style="width:200px; height:auto; padding-bottom:10px">
                                                        </div>
                                                        <div class="col-sm-5">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <label for="file-upload">
                                                                <button class="btn">Select Image</button>
                                                            </label>
                                                            <input id="file-upload" type="file"/></br>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="pull-right">First Name</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" name="first_name" placeholder="First Name" class="required prefill" value="{{ $first_name }}"><span class="error"></span></br>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="pull-right">Last Name</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" name="last_name" placeholder="Last Name" class="required prefill" value="{{ $last_name }}"><span class="error"></span></br>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <h4><b>Account Login</b></h4>
                                                        </div>
                                                    </div>
                                                    @if(Auth::user()->hasRole('administrator') || Auth::user()->hasRole('admin'))
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="pull-right">Status</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <select name="status" id="status">
                                                                <option value="Active" @if($status == 'Active') selected @endif>Active</option>
                                                                <option value="InActive" @if($status == 'InActive') selected @endif>InActive</option>
                                                            </select><span class="error"></span></br>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <label class="pull-right">Email</label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input class="form-control" name="email" placeholder="Email" class="required prefill" value="{{ $email }}"><span class="error"></span></br>
                                                        </div>
                                                    </div>
                                                    @if($action_name!="Add")
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label class="pull-right">
                                                                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#password_field">Edit Password</a>
                                                                </label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                &nbsp;
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div id="password_field" @if($action_name!="Add") class="collapse" @endif>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label class="pull-right">Password</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input class="form-control" name="password" type="password" class="required prefill"><span class="error"></span></br>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <label class="pull-right">Confirm</label>
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input class="form-control" name="confirm" type="password" class="required prefill"><span class="error"></span></br>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="submit" class="btn btn-lg btn-primary" style="background-color:#084E9A; margin-left:10px;" value="Submit">
                                                <a href="{{ route('users')}}" class="btn btn-lg btn-danger">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        &nbsp;
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="{{ asset('js/lib/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/user_form.js') }}"></script>
@stop