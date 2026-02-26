@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header bg-dark">
                    <h3 class="brand-text text-center">How To Use</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <ul class="list-group">
                            <li class="list-group-item">1. <strong>Upload or Take a photo</strong> from left camera icon.</li>
                            <li class="list-group-item">2. <strong>Select Target</strong> Color Box from bottom left.</li>
                            <li class="list-group-item">3. Click Color <strong>Picker Icon</strong> at the top middle area.</li>
                            <li class="list-group-item">4. <strong>Select Current</strong> and pick color again from image.</li>
                            <li class="list-group-item">5. After pick color on TARGET & Current, you will get NEEDED <strong>automatically</strong>, which is your result.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection