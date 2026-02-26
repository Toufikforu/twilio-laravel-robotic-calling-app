@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center h-screen bg-gray-100">
    <div class="text-center p-6 bg-white shadow-lg rounded-lg">
        <h1 class="text-4xl font-bold text-red-500">419</h1>
        <p class="text-xl mt-2 text-gray-700">Session Expired</p>
        <p class="text-sm text-gray-500">Your session has expired due to inactivity.</p>
        <a href="{{ route('login') }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-lg">
            Go to Login
        </a>
    </div>
</div>
@endsection
