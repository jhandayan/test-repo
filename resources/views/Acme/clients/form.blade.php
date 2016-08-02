
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
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('users') }}">Users</a></li>
                <li class="active">@if($action_name == 'Add')Add User @else Edit {{ $first_name  }} @endif</li>
            </ul>
        </div>
        <div class="col-sm-1"></div>
    </div>
<div class="container">
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
    <form role="form" action="{{ $action }}" method="post" class="form">
        <div class="row">
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
                                        <input class="form-control" name="first_name" placeholder="First Name" value="{{ $first_name }}"></br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="pull-right">Last Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="last_name" placeholder="Last Name" value="{{ $last_name }}"></br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="pull-right">Nickname</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="nickname" placeholder="nickname" value="{{ $nickname }}"></br>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class="col-sm-3">
                                        <label class="pull-right">Date of Birth</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="birthdate" value="{{ $birthdate }}"></br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="pull-right">Gender</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender">
                                            <option value="male" >Male</option>
                                            <option value"female" >Female</option>
                                        </select></br>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4><b>Account Login</b></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="pull-right">Email</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="email" placeholder="Email" value="{{ $email }}"></br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="pull-right">Password</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input class="form-control" name="password"></br>
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-building"></i>&nbsp;Company Details</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Employee ID</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Employee ID"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Department</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control">
                                    <option>PHP</option>
                                    <option>Java</option>
                                </select></br>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Position</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control" name="position">
                                    <option>Fresh PHP Developer</option>
                                    <option>Senior PHP Developer</option>
                                </select></br>   
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Date of Joining</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" name="date_hired" value="{{ $date_hired }}"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Joining Salary</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Current Salary"></br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-primary">
                    <div class="panel-heading"><i class="fa fa-university"></i>&nbsp;Bank Account Details</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Account Holder Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Account Holder Name"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Account Number</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="Account Number"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Bank Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="BANK Name"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">IFSC Code</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="IFSC Code"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">PAN Number</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="PAN Number"></br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <label class="pull-right">Branch</label>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" placeholder="BRANCH"></br>
                            </div>
                        </div>
                    </div>
                </div>
                 {!! csrf_field() !!}
                 <div class="row">
                    <div class="col-sm-6">
                        
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-primary pull-right" style="background-color:#084E9A; margin-left:10px;" value="Submit">
                        <a href="{{ route('clients')}}"><input type="button" class="btn btn-danger pull-right" value="Cancel"></a>
                    </div>
                 </div>  
            </div>
        </div>
    </form>
</div>

@endsection