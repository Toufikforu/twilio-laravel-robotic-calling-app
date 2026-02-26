@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-logo />
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8  mb-5">
            <div class="card">
                <div class="card-header rtd-header">{{ __('Register an Account') }}</div>

                <div class="card-body">
                <form method="POST" action="{{ route('register') }}" id="registrationForm">
    @csrf

    <!-- Question 1 -->
    <div class="mb-3">
        <label for="usage" class="form-label d-block text-start fw-bold">
            1. So we can best serve the community, how will you use the Dyebold App? (Be specific)<span class="text-danger">*</span>
        </label>
        <textarea id="usage" class="form-control" name="usage" minlength="10" maxlength="100" placeholder="Min 10 characters & Max 100" style="height: 80px;" required>{{ old('usage') }}</textarea>
        <div class="text-danger" id="error-usage">{{ $errors->first('usage') }}</div>
    </div>

    <!-- Question 2 -->
    <div class="mb-3 text-start">
        <label class="form-label d-block fw-bold">
            2. Which Dye Training have you taken?<span class="text-danger">*</span>
        </label>
        @php
            $trainings = [
                'IICRC Carpet Dyeing' => 'iicrc',
                'DyeBold Nylon Carpet Dyeing' => 'nylon',
                'Dyebold Polyester Carpet Dyeing' => 'polyester',
                'Dyebold Rug Dyeing' => 'rug',
                'Colorful Carpets' => 'colorful',
                'None but would love to!' => 'none',
            ];
        @endphp

        @foreach ($trainings as $label => $id)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="training[]" id="{{ $id }}" value="{{ $label }}"
                       {{ in_array($label, old('training', [])) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
            </div>
        @endforeach
        <div class="text-danger" id="error-training">{{ $errors->first('training') }}</div>
    </div>

    <!-- Question 3 -->
    <div class="mb-3">
        <label for="dyes" class="form-label d-block text-start fw-bold">
            3. Which dyes do you currently use?<span class="text-danger">*</span>
        </label>
        <input type="text" id="dyes" name="dyes" class="form-control" minlength="2" maxlength="15"
               placeholder="Min 2 & Max 15 characters" style="height: 40px;" required
               value="{{ old('dyes') }}">
        <div class="text-danger" id="error-dyes">{{ $errors->first('dyes') }}</div>
    </div>

    <!-- Name -->
    <div class="mb-3">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
        <div class="text-danger" id="error-name">{{ $errors->first('name') }}</div>
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
        <div class="text-danger" id="error-email">{{ $errors->first('email') }}</div>
    </div>

    <!-- Company -->
    <div class="mb-3">
        <label for="company">Company Name</label>
        <input type="text" name="company" id="company" class="form-control" value="{{ old('company') }}">
        <div class="text-danger" id="error-company">{{ $errors->first('company') }}</div>
    </div>

    <!-- Role -->
    <div class="mb-3">
        <label for="role">Your Role</label>
        <input type="text" name="role" id="role" class="form-control" value="{{ old('role') }}">
        <div class="text-danger" id="error-role">{{ $errors->first('role') }}</div>
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        <div class="text-danger" id="error-password">{{ $errors->first('password') }}</div>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        <div class="text-danger" id="error-password_confirmation"></div>
    </div>

    <button type="submit" class="btn btn-primary rtd-btn-footer px-5">Register</button>
</form>

                </div>

                <!-- Footer Area start -->
<div class="card-footer rtd-footer">


<div class="row">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">
         
            <li class="nav-item">
                <a class="btn btn-primary rtd-btn-footer" href="{{ route('login') }}">{{ __('Back to Login') }}</a>
            </li>
    </ul>
</div>

</div>
<!-- Footer Area End -->
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registrationForm');

    const fields = {
        usage: {
            element: document.getElementById('usage'),
            error: document.getElementById('error-usage'),
            validate: value => value.trim().length >= 10 && value.length <= 100 ? '' : 'Usage must be between 10 and 100 characters'
        },
        training: {
            element: document.getElementsByName('training[]'),
            error: document.getElementById('error-training'),
            validate: () => {
                const checked = Array.from(fields.training.element).some(el => el.checked);
                return checked ? '' : 'Select at least one training option';
            }
        },
        dyes: {
            element: document.getElementById('dyes'),
            error: document.getElementById('error-dyes'),
            validate: value => value.trim().length >= 2 && value.length <= 15 ? '' : 'Dyes must be between 2 and 15 characters'
        },
        name: {
            element: document.getElementById('name'),
            error: document.getElementById('error-name'),
            validate: value => value.trim() !== '' ? '' : 'Name is required'
        },
        email: {
            element: document.getElementById('email'),
            error: document.getElementById('error-email'),
            validate: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) ? '' : 'Invalid email address'
        },
        company: {
            element: document.getElementById('company'),
            error: document.getElementById('error-company'),
            validate: value => value.trim() !== '' ? '' : 'Company name is required'
        },
        role: {
            element: document.getElementById('role'),
            error: document.getElementById('error-role'),
            validate: value => value.trim() !== '' ? '' : 'Role is required'
        },
        password: {
            element: document.getElementById('password'),
            error: document.getElementById('error-password'),
            validate: value => /^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.{8,})/.test(value) ? '' : 'Password must be at least 8 characters and include a number and special character'
        },
        password_confirmation: {
            element: document.getElementById('password_confirmation'),
            error: document.getElementById('error-password_confirmation'),
            validate: (value) => value === fields.password.element.value ? '' : 'Passwords do not match'
        }
    };

    // Attach input/change events
    Object.keys(fields).forEach(key => {
        const field = fields[key];
        const inputEl = field.element;

        if (key === 'training') {
            Array.from(inputEl).forEach(el => el.addEventListener('change', () => validateField(key)));
        } else {
            inputEl.addEventListener('input', () => validateField(key));
        }
    });

    function validateField(key) {
        const field = fields[key];
        const value = key === 'training' ? null : field.element.value;
        const errorMessage = field.validate(value);
        field.error.textContent = errorMessage;
        return errorMessage === '';
    }

    form.addEventListener('submit', function (e) {
        let isValid = true;
        Object.keys(fields).forEach(key => {
            if (!validateField(key)) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault(); // Stop form submission
        }
    });
});
</script>



@endsection
