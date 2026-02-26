@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        
            @if(session()->has('message'))
                <div class="alert alert-success" id="success-alert">
                    {{ session()->get('message') }}
                </div>
            @endif
  
        <div class="col-md-12">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <h3>Create User</strong></h3>

                </div>
                <div class="card-body">

                        <form action="" method="post">
                            @csrf
                            
                            <div class="col-md-6">
                                <ul>
                                    <li>
                                        <label>Name: </label>
                                        <input type="text" name="name" class="form-control"/>
                                    </li>
                                    <li>
                                        <label>Email: </label>
                                        <input type="text" name="email" class="form-control"/>
                                    </li>
                                    
                                    <li>
                                        <label>Password: </label>
                                        <input id="password" type="password" class="form-control" name="password">
                                    </li>

                                </ul>
                            </div>
                            
                            <button class="btn btn-primary">Update</button>
                        </form>

                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

