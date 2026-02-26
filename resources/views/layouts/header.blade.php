<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="RTDITZONE">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="keywords" content="RTDITZONE, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="shortcut icon" href="{{asset('user/img/favicon.png')}}" />

	<title>@yield('title', 'Dashboard')</title>

	<!-- Latest Inter Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<!--  Updated Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
	
	<!--  Updated Font Awesome  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

	<!-- Local Assets -->
	<link href="{{asset('admin/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/global-style-rtd-it-zone.css')}}" rel="stylesheet">
	</head>

	<body>