@extends('layouts.main')
@section('title', 'User Dashboard | ' . config('app.name'))


@section('content')

<div class="container-fluid p-0">

<h1 class="h3 mb-3">Dashboard</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>Status: <span id="approval-status" class="{{ auth()->user()->is_admin_approved ? 'text-success' : 'text-danger' }}">
        {{ auth()->user()->is_admin_approved ? 'Approved' : 'Pending ' }}
    </span></p>


<div class="row">
            <!-- First Card -->
            <div class="col-md-4">
                <div class="card text-white bg-dark shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center brand-text">Account Details</h5>
                        <p class="card-text p-3">
                            <strong>Name:</strong> {{ $user->name ?? 'N/A' }} <br>
                            <strong>Email:</strong> {{ $user->email ?? 'N/A' }} <br>
                            <strong>Created:</strong> {{ $user->created_at->format('d-m-Y') ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>


        </div>




@endsection