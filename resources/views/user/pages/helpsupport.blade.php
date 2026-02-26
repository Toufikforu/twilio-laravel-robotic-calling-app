@extends('layouts.main')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center ">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h3 class="brand-text text-center">Open a Ticket</h3>
                </div>
                <div class="card-body py-3">
                    @if(session('ticket_number'))
                        <div class="alert alert-success mt-3">
                            Your Ticket Number: <strong>{{ session('ticket_number') }}</strong>
                        </div>
                    @endif
                    <!-- Contact Support Form -->
                    <form action="{{ route('ticket.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="ticket_number" class="form-label">Ticket Number</label>
                            <input type="text" class="form-control" id="ticket_number" name="ticket_number" 
                                value="{{ session('ticket_number') ?? 'After Submit Your Ticket will Display' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rtd-btn">Submit my ticket</button>
                    </form>

                   


                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card" id="help">
                    <div class="card-header bg-dark text-white">
                        <h3 class="brand-text text-center">Quick Call</h3>
                    </div>
                    <div class="card-body py-3 d-flex align-items-center">
                        <i class="fa fa-phone me-2"></i> 
                        <h3 class="mb-0">+60-1735-99462</h3>
                    </div>

            </div>
        </div>
    </div>
</div>

@endsection
