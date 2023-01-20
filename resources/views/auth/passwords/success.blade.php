@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card-group">
            <div class="card p-4">
                <div class="card-body">
                    <!-- <form method="POST" action="{{ route('password.request') }}"> -->
                        {{ csrf_field() }}
                        <h1>
                            <div class="login-logo text-center">
                                <a href="#">                                    
                                    <img src="{{ asset('img/logosmall.png') }}" alt="Fitmatch">
                                </a>
                                <h1>Reset Password Success</h1>
                            </div>
                        </h1>
                        <p class="text-muted"></p>                    
                    <!-- </form> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
