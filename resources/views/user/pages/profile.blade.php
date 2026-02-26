@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ">

            <div class="card">
                <div class="card-header bg-dark">
                    <div class="card-header bg-dark">
                    <h4 class="text-center brand-text" ><i class="fa fa-user me-2"></i> Edit Profile</h4>
                </div>
                </div>
                <div class="card-body p-3">
                         @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                    
                        

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            <div class="row">
                            <div class="col-md-4">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email</label>
                                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-bold">New Password (optional)</label>
                                        <input type="password" name="password" id="password" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                    </div>

                                   
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <label for="company" class="form-label fw-bold">Company</label>
                                        <input type="text" name="company" id="company" class="form-control" value="{{ old('company', $user->company) }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label fw-bold">Role</label>
                                        <input type="text" name="role" id="role" class="form-control" value="{{ old('role', $user->role) }}">
                                    </div>

                                       
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-body">
                                    <div class="mb-3">
                                        <label for="pmtype" class="form-label fw-bold">Payment Method</label>
                                        
                                        <input type="text" name="pm_type" id="pmtype" class="form-control" 
       value="{{ old('pm_type', $user->pm_type ?? 'No Card Selected') }}" disabled>


                                    </div>

                                    <div class="mb-3">
                                        <label for="pmlastfour" class="form-label fw-bold">Card Last 4 Digit</label>
                                        <input type="text" name="pm_last_four" id="pmlastfour" class="form-control" 
       value="{{ old('pm_last_four', $user->pm_last_four ?? 'No Card Selected') }}" disabled>


                                    </div>
                                     
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary rtd-btn">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection