<div class="col-md-12 text-center mt-3 py-4 rtd-logo">
    <a href="{{url('/')}}" class="text-decoration-none">
        @php
            $logoPath = public_path('assets/images/logo.webp');
        @endphp

        @if(file_exists($logoPath))
            <img src="{{ asset('assets/images/logo.webp') }}" width="180" height="70">
        @else
            <h3 class="brand-text">{{config('app.name')}}</h3>
        @endif
    </a>
</div> 