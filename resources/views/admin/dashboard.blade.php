@extends('layouts.main')
@section('title', 'Admin Dashboard | ' . config('app.name'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Admin Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="row" id="userStatus">
                            
                            
                        


                            <div class="col-md-4">
                                <div class="card text-white bg-dark shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title text-center brand-text">User Details</h5>
                                        <p class="card-text px-4">
                                            <p>Total User: <span>{{$liza}}</span></p>
                                            <p>Active User: <span class="Active">{{$activeUserCount}}</span></p>
                                            <p>Not Active User: <span class="inActive">{{$inActiveUserCount}}</span></p>
                                        
                                        </p>
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

