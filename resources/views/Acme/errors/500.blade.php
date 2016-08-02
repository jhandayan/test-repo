@extends('Acme.errors.template')
@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-lg-12">
                <div class="centering text-center">
                    <div class="text-center">
                        <h2 class="without-margin">Don't worry. It's <span class="text-danger"><big>500</big></span> error only.</h2>
                        <h4 class="text-danger">Something is broken, but we will fix it soon</h4>
                    </div>
                    <div class="text-center">
                        <h3><small>Click the link below</small></h3>
                    </div>
                    <hr>
                    @if(Auth::check())
                        <ul class="pager">
                            <ul class="pager">
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            </ul>
                        </ul>
                    @else
                        <ul class="pager">
                            <ul class="pager">
                                <li><a href="{{ route('home') }}">Home</a></li>
                            </ul>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection