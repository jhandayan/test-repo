@extends('Acme.layouts.template')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{ route('home') }}">Dashboard</a></li>
                <li><a href="{{ route('users') }}">Users</a></li>
                <li class="active">{{ $user->full_name  }} Profile</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>{{ $user->full_name  }} Profile</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default bootstrap-admin-no-table-panel">
                <div class="panel panel-default bootstrap-admin-no-table-panel">
                    <div class="panel-heading">
                        <div class="text-muted bootstrap-admin-box-title">{{ $user->full_name  }} Profile</div>
                    </div>
                    <div class="bootstrap-admin-no-table-panel-content bootstrap-admin-panel-content collapse in">
                        <div class="row">
                            <div class="col-sm-4">
                                <ul class="list-group" style="text-align: center">
                                    <li class="list-group-item active">
                                        <i style="color: white" class="fa fa-user"></i> Profile
                                    </li>
                                    <li class="list-group-item">
                                        <img src="{{ asset('images/default_user.png') }}">
                                    </li>
                                    <li class="list-group-item">
                                        {{ $user->first_name." ".$user->last_name }}
                                    </li>
                                    <li class="list-group-item">
                                        Status: {{ $user->status  }}
                                    </li>
                                    <li class="list-group-item">
                                        Email: {{ $user->email  }}
                                    </li>
                                </ul>

                                <!--  Work Status  -->
                                <div class="row"  style="text-align: center;color: white">
                                    <div class="col-sm-4">
                                        <div class="profile-work-box"><br/>
                                            Current Rate:<br/>8000
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="profile-work-box"><br/>
                                            Leaves:<br/> 3/12
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="profile-work-box"><br/>
                                            Attendance:<br/> 119/200
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul class="list-group">
                                            <li class="list-group-item active">
                                                <i style="color: white" class="fa fa-info-circle fa-lg"></i> Personal Information
                                            </li>
                                            <li class="list-group-item">
                                                First Name: {{ $user->first_name  }}
                                            </li>
                                            <li class="list-group-item">
                                                Last Name: {{ $user->last_name  }}
                                            </li>
                                            <li class="list-group-item">
                                                Age: {{ $user->PersonalInfo()->age or ''  }}
                                            </li>
                                            <li class="list-group-item">
                                                Occupation: {{ $user->PersonalInfo()->occupation or ''  }}
                                            </li>
                                            <li class="list-group-item">
                                                Working with Financial Adviser? {{ $user->PersonalInfo()->working_with_financial_adviser or ''  }}
                                            </li>
                                        </ul>
                                        <!--  Family Information -->
                                        <ul class="list-group">
                                            <li class="list-group-item active">
                                                <i style="color: white" class="fa fa-info-circle fa-lg"></i> Family Information
                                            </li>
                                            <li class="list-group-item">
                                                Married? {{ $user->PersonalInfo()->married or ''  }}
                                            </li>
                                            <li class="list-group-item">
                                                Spouse Name: {{ $user->PersonalInfo()->spouse_name or ''  }}
                                            </li>
                                            <li class="list-group-item">
                                                Spouse Age: {{ $user->PersonalInfo()->spouse_age or '' }}
                                            </li>
                                            <li class="list-group-item">
                                                Children
                                            </li>
                                            <li class="list-group-item">
                                                Working with Financial Adviser? {{ $user->PersonalInfo()->working_with_financial_adviser or ''  }}
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="col-sm-6">
                                        <!--  Announcements  -->
                                        <ul class="list-group">
                                            <li class="list-group-item active">
                                                <i class="fa fa-calendar fa-lg"></i>&nbsp; Announcements
                                            </li>
                                            <div style="max-height: 200px; overflow: auto;">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-8">
                                                            <a href="">Title</a>
                                                            <br/>
                                                            Details Details Details Details
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-8">
                                                            <a href="">Title</a>
                                                            <br/>
                                                            Details Details Details Details
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-8">
                                                            <a href="">Title</a>
                                                            <br/>
                                                            Details Details Details Details
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-8">
                                                            <a href="">Title</a>
                                                            <br/>
                                                            Details Details Details Details
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-8">
                                                            <a href="">Title</a>
                                                            <br/>
                                                            Details Details Details Details
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-8">
                                                            <a href="">Title</a>
                                                            <br/>
                                                            Details Details Details Details
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        </ul>

                                        <!--  Payslips  -->
                                        <ul class="list-group">
                                            <li class="list-group-item active">
                                                <i style="color: white" class="fa fa-money fa-lg"></i>&nbsp; Payslips
                                            </li>
                                            <div style="max-height: 200px; overflow: auto;">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-credit-card fa-lg"></i> : 8200
                                                            <br/><a href="#">Details >></a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-money fa-lg"></i> : 9000
                                                            <br/><i class="fa fa-minus-circle fa-lg"></i> : 800
                                                        </div>
                                                    </div>
                                                </li>

                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-credit-card fa-lg"></i> : 8200
                                                            <br/><a href="#">Details >></a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-money fa-lg"></i> : 9000
                                                            <br/><i class="fa fa-minus-circle fa-lg"></i> : 800
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-credit-card fa-lg"></i> : 8200
                                                            <br/><a href="#">Details >></a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-money fa-lg"></i> : 9000
                                                            <br/><i class="fa fa-minus-circle fa-lg"></i> : 800
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-4" style="text-align: center">09<br/> 15, 2015</div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-credit-card fa-lg"></i> : 8200
                                                            <br/><a href="#">Details >></a>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <i class="fa fa-money fa-lg"></i> : 9000
                                                            <br/><i class="fa fa-minus-circle fa-lg"></i> : 800
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        </ul>

                                        <!-- Absents -->
                                        <ul class="list-group">
                                            <li class="list-group-item active">
                                                <i class="fa fa-exclamation-circle fa-lg"></i>&nbsp; Absents
                                            </li>
                                            <div style="max-height: 200px; overflow: auto;">
                                                <li class="list-group-item">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            3 days ago
                                                        </div>
                                                        <div class="col-sm-6">
                                                            April 3, 2016
                                                        </div>
                                                    </div>
                                                </li>
                                            </div>
                                        </ul>
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