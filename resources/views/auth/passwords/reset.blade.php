@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-logo />  
    </div>   
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header rtd-header">{{ __('Reset Password') }}</div>

                <div class="card-body">

                <!-- Display Message -->
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

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div id="password-strength" class="password-strength"></div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for password strength checker -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const strengthMeter = document.getElementById('password-strength');

        function updatePasswordStrength() {
            const password = passwordField.value;
            let score = 0;

            // Basic length requirement
            if (password.length >= 10) score += 20; // Full points for length >= 10

            // Check for character types
            const hasLower = /[a-z]/.test(password);
            const hasUpper = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[^a-zA-Z0-9]/.test(password);

            if (hasLower) score += 20;
            if (hasUpper) score += 20;
            if (hasNumber) score += 20;
            if (hasSpecial) score += 20;

            // Ensure score is within bounds
            score = Math.min(score, 100);

            // Determine feedback message
            let feedbackMessage = '';
            if (score < 100) {
                feedbackMessage = `Password strength: ${score}%<br>
                Please include at least 10 characters,<br>
                including uppercase letters, lowercase letters,<br>
                numbers, and special characters.<br>
                Example: aA10dE&%$!~dE`;
                if (password.length < 10) {
                    feedbackMessage += `<br>Your password is ${10 - password.length} characters short of the required length.`;
                }
            } else {
                feedbackMessage = `Password strength: ${score}%<br>
                Your password meets all requirements.`;
            }

            strengthMeter.innerHTML = feedbackMessage;
            strengthMeter.className = `password-strength strength-${Math.floor(score / 20)}`;
        }

        passwordField.addEventListener('input', updatePasswordStrength);
    });
</script>

<!-- CSS for password strength checker (Add this to your CSS file or in a <style> tag) -->
<style>
    .password-strength {
        font-weight: bold;
        margin-top: 5px;
    }

    .password-strength.strength-0 { color: red; }
    .password-strength.strength-1 { color: red; }
    .password-strength.strength-2 { color: red; }
    .password-strength.strength-3 { color: red; }
    .password-strength.strength-4 { color: red; }
</style>
@endsection
