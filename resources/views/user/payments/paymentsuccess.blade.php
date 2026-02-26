@extends('user.layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Payment Result') }}</div>

                <div class="card-body">
                   
                    <div class="alert alert-success" role="alert">
                        Subscription Purchase Successfully!
                    </div>

                    Congratulation! You may go <a href="{{route('userdashboard')}}" class="btn btn-primary dyebold-color">User Dashboard</a> Now.
                   
                </div>
            </div>
        </div>
    </div>
</div>


@endsection




