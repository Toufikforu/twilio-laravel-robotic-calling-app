<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="RTDITZONE">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="RTDITZONE, bootstrap, dashboard, responsive, ui kit, web">

	<link rel="shortcut icon" href="{{ asset('user/img/favicon.png') }}" />

	<title>@yield('title', 'Dashboard')</title>

	<!-- Fonts & Icons -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

	<!-- Local CSS -->
	<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('assets/css/global-style-rtd-it-zone.css') }}" rel="stylesheet">
	 <!-- Role-based CSS -->
    <!-- Role-based CSS -->
    @if(Auth::check() && Auth::user()->is_admin)
        <link href="{{ asset('admin/css/admin.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('user/css/user.css') }}" rel="stylesheet">
    @endif

    @yield('styles')
</head>

<body>

	{{-- Header/Menu --}}
	@if(auth()->user()->access_status == 1)
        @include('admin.menu')
    @else
        @include('user.components.menu')
    @endif


	{{-- Main content --}}
	<main class="container py-4" style="min-height: calc(100vh - 120px);">
		@yield('content')
	</main>



	{{-- Optional Footer --}}
	@includeIf('layouts.footer')




	<!-- Role-based JS -->
	
	<script>
		window.appData = {
			lastStatus: "{{ auth()->user()->is_admin_approved ? 'approved' : 'pending' }}",
			checkStatusUrl: "{{ route('check.approval.status') }}"
		};
	</script>


    @if(Auth::check() && Auth::user()->is_admin)
        <script src="{{ asset('admin/js/admin.js') }}"></script>
    @else
        <script src="{{ asset('user/js/user.js') }}"></script>
    @endif

    @yield('scripts')
</body>
</html>
