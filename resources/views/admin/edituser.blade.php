@extends('layouts.main')

@section('content')

<style>
	ul.edit-user li {
		list-style: none;
		margin-bottom: 15px;
	}

</style>


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
                    <h3>Edit User: <strong>{{ $liza->name }}</strong></h3>

                </div>
                <div class="card-body">

                <form action="{{ route('updateUser', ['id' => $liza->id]) }}" method="post">
                    @csrf
                    
                    <div class="col-md-6">
                        <ul class="edit-user">
                            <li>
                                <label>Name:</label>
                                <input type="text" value="{{ $liza->name }}" name="name" class="form-control" />
                            </li>
                            <li>
                                <label>Email:</label>
                                <input type="text" value="{{ $liza->email }}" name="email" class="form-control" />
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="is_admin_approved" {{ $liza->is_admin_approved ? 'checked' : '' }}>
                                    Admin Approved
                                </label>
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

