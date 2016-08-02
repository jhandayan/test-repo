@extends('Acme.layouts.template')
@section('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/wealth_score.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/action_steps.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.idealforms.css')  }}">
    <style>
        .results {
            height: 300px;
        }
        #illustrative_plan caption{
            font-weight: bold;
            text-align: center;
        }
        #illustrative_plan td, #illustrative_plan th{padding: 3px}
        #illustrative_plan{
            width: 1800px !important;
        }
    </style>

@stop
@section('content')
    <div class="idealsteps-container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="active">Dashboard</li>
                </ul>
            </div>
        </div>


    </div>


    <div class="container">


    </div>

@endsection

