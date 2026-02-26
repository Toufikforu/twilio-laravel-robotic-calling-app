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
            <!-- First Card with Plan Details -->
            <div class="col-md-4">
    <div class="card bg-dark text-white shadow-lg">
    <div class="card-body">
    <!-- Centered Title -->
    <h3 class="card-title text-center brand-text mb-3">Subscription Details</h3>

    @php
        $user = auth()->user();
        $isAdminApproved = $user->is_admin_approved ?? false;
        $hasSubscription = isset($latestSubscription);

        $isStripeActive = $hasSubscription &&
            $latestSubscription->stripe_status === 'active' &&
            optional($latestSubscription->created_at)->addMonth()->isFuture() &&
            \Carbon\Carbon::parse($user->created_at)->addMonths(12)->isFuture();

        $isApproved = $isStripeActive || $isAdminApproved;
    @endphp

    @if ($isApproved)
        <div class="table-responsive">
            <table class="table table-dark table-striped text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Plan Name</th>
                        <th>Status</th>
                        <th>Subscription Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold">{{ $latestSubscription->plan->name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $isStripeActive ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $isStripeActive ? 'Approved' : 'Admin Approved' }}
                            </span>
                        </td>
                        <td>
                            @if ($hasSubscription && $latestSubscription->created_at)
                                {{ $latestSubscription->created_at->format('d M Y') }}
                            @elseif ($user->admin_approval_date)
                                {{ \Carbon\Carbon::parse($user->admin_approval_date)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    @else
        <p class="alert bg-danger text-center">No active subscriptions found.</p>
    @endif
</div>



    </div>
</div>

            <!-- Second Card -->
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

            <!-- Third Card -->
            <div class="col-md-4">
                <div class="card text-white bg-dark shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-center brand-text">Quick Access</h5>

                        @if (($latestSubscription && $latestSubscription->stripe_status === 'active') || Auth::user()->is_admin_approved)
                            <ul class="row">
                                <li class="col-6 col-sm-6 col-md-6 list-unstyled">
                                    <a href="#"><button class="btn btn-success mb-3 w-100">Paid Page</button></a>
                                </li>
                                <li class="col-6 col-sm-6 col-md-6 list-unstyled">
                                    <a href="#"><button class="btn btn-success w-100">Save Page</button></a>
                                </li>
                            </ul>
                        @else
                            <h5 class="card-title text-center brand-text">Free Access</h5>
                            <ul>
                                <li class="list-unstyled">
                                    <a href="#"><button class="btn btn-danger mb-3">Upload CSV</button></a>
                                </li>
                            </ul>
                        @endif
                    </div>

                </div>
            </div>
        </div>




@endsection