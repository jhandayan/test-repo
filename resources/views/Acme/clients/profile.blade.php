
@extends('Acme.layouts.template')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('clients') }}">Clients</a></li>
                <li class="active">{{ $user->first_name . ' ' . $user->last_name }} Profile</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>{{ $user->first_name . ' ' . $user->last_name }} Profile</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">{{ $user->first_name . ' ' . $user->last_name }} Profile</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
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
                                                    <input class="form-control" name="first_name" placeholder="First Name" value="{{ $user->first_name }}" disabled></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Last Name</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="last_name" placeholder="Last Name" value="{{ $user->last_name }}" disabled></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Age</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <input class="form-control" name="age" value="{{ @$metas['age'] }}" disabled></br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label class="pull-right">Gender</label>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="gender" disabled>
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
                                                    <input class="form-control" name="email" placeholder="Email" value="{{ $user->email }}" disabled></br>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><i class="fa fa-building"></i>&nbsp;Account Details</div>
                                    <div class="panel-body">
                                        @if(count($metas) != 0)
                                            <?php $age = $metas['childage'];?>
                                            @foreach($metas as $key => $value)

                                                @if($key == 'childname')
                                                    <fieldset>
                                                        <legend>Childs</legend>
                                                        @foreach($value as  $key => $child )
                                                            <div class="row">
                                                                <div class="col-sm-8"><label>Child's Name </label> {{ $child }}</div>
                                                                <div class="col-sm-4"><label>Age</label> {{ $age[$key] }}</div>
                                                            </div>
                                                        @endforeach
                                                    </fieldset>

                                                @elseif($key != 'childage')
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <label class="pull-right">{{ ucfirst(str_replace(['_', '-'], ' ', $key)) }}</label>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <input class="form-control" placeholder="" value="{{ is_string($value) ? $value : '' }}" disabled></br>
                                                        </div>
                                                    </div>
                                                @endif

                                                <?php unset($metas[$key]);?>
                                                <?php if($key == 'have_child_special_needs'): break;endif;?>
                                            @endforeach
                                        @else
                                            Details not available
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">

                                    </div>
                                    <div class="col-sm-6">

                                        <a href="{{ route('clients')}}"><input type="button" class="btn btn-danger pull-right" value="Cancel"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection