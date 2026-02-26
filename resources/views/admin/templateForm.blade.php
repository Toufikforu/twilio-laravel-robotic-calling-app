@extends('layouts.main')

@section('content')

<div class="container">
    <div class="row justify-content-center">




        <div class="col-md-8">
            <div class="card">

                @if(session('success'))
                    <div id="successMessage" class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                

                <div class="card-header justify-content-between d-flex">
                    <h3>Template Email Sending</h3>
                       
                </div>

                <div class="card-body p-4">
                    
                <form id="emailForm" action="{{ route('sendingEmailDropdown') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="to" class="form-label">To<span class="text-danger">*</span></label>
                        <input type="email" id="to" name="to" placeholder="Recipient's Email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject<span class="text-danger">*</span></label>
                        <input type="text" id="subject" name="subject" placeholder="Email Subject" class="form-control" required>
                    </div>

                    <!-- Template dropdown -->
                    <div class="mb-3" id="templateSection">
                        <label for="template" class="form-label">Select Template<span class="text-danger">*</span></label>
                        <select id="template" name="template" class="form-control" required>
                            <option value="">Choose Template</option>
                            <option value="template1">Template 1</option>
                            <option value="template2">Template 2</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>

                




                </div>
            </div>
        </div>
    </div>
</div>


<!-- Success Message Hide After 3 Seconds -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);
    });
</script>


@endsection