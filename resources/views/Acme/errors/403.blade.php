@extends('Acme.errors.template')
@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-lg-12">
                <div class="centering text-center error-container">
                    <div class="text-center">
                        <h2 class="without-margin">Don't worry. It's <span class="text-warning"><big>403</big></span> error only.</h2>
                        <h4 class="text-warning">Access denied</h4>
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