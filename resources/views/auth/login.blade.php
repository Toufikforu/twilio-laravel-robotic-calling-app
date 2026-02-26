@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <x-logo />  
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header rtd-header">{{ __('User Login') }}</div>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mb-3 ">
                            <div class="col-md-4 d-flex align-items-center">
                                <!-- Bigger icon -->
                                <i class="fas fa-user-shield rtd-icon" style="font-size: 24px;"></i>
                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                            </div>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-3">
                            <div class="col-md-4 d-flex align-items-center">
                                <i class="fa-solid fa-lock rtd-icon" style="margin-right:10px;"></i>
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>

                                    
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}" style="padding-left:0px;">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-success rtd-btn" id="rtd-btn-reg">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('register'))
                                    <a class="btn btn-success rtd-btn" id="rtd-btn-reg" href="{{ route('register') }}">
                                        {{ __('Free Registration') }} 
                                    </a>
                                @endif

                            </div>


                        </div>
                    </form>
                </div>
<!-- Footer Area start -->
<div class="card-footer rtd-footer">


                <div class="row">
                    <!-- Left Side Of Navbar -->
                    <!-- <ul class="navbar-nav mr-auto">
                         @guest
						 
                            <li class="nav-item">
                                <button class="btn btn-primary rtd-btn" id="rtd-btn-login"><a class="nav-link" href="{{ route('login') }}">{{ __('Go Sign in Page') }}</a></button>
                            </li>
                    </ul> -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav">
                        <!-- Authentication Links -->

                        @else
							
						<div class="row">
							<div class="col-md-12">
								<div class="d-flex justify-content-between">
								
									<li class="nav-item dropdown">
										<a id="navbarDropdown" class="nav-link dropdown-toggle" href="javascript:void(0)" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
											{{ Auth::user()->name }} <span class="caret"></span>
										</a>

										<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
											<a class="dropdown-item" href="{{ route('logout') }}"
											   onclick="event.preventDefault();
															 document.getElementById('logout-form').submit();">
												{{ __('Logout') }}
											</a>

											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
											</form>
										</div>
									</li>
									
									<li class="p-1 ml-4">
										<a href="{{route('userdashboard')}}">
											Go to Dashboard
										</a>
									</li>
								</div>
							</div>
						</div>
                        @endguest
                    </ul>
                </div>

</div>
<!-- Footer Area End -->

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("nextStep").addEventListener("click", function () {
        // Validate Step 1 fields before moving to Step 2
        validateUsage();
        validateDyes();

        const isUsageValid = !document.getElementById('usage').classList.contains('is-invalid');
        const isDyesValid = !document.getElementById('dyes').classList.contains('is-invalid');

        if (isUsageValid && isDyesValid) {
            // Move to Step 2 if no errors
            document.getElementById("step1").style.display = "none";
            document.getElementById("step2").style.display = "block";
            document.getElementById("modalTitle").innerText = "Step 2: Register";
        } else {
            // Optionally scroll to the first error field
            const firstError = document.querySelector('.is-invalid');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth' });
        }
    });

    document.getElementById("backStep").addEventListener("click", function () {
        document.getElementById("step2").style.display = "none";
        document.getElementById("step1").style.display = "block";
        document.getElementById("modalTitle").innerText = "Step 1: Answer Questions";
    });

    function validateUsage() {
        const usageInput = document.getElementById('usage');
        const errorText = document.getElementById('usageError');
        const valueLength = usageInput.value.trim().length;

        if (valueLength < 10 || valueLength > 100) {
            errorText.style.display = 'block';
            usageInput.classList.add('is-invalid');
        } else {
            errorText.style.display = 'none';
            usageInput.classList.remove('is-invalid');
        }
    }

    function validateDyes() {
        const dyesInput = document.getElementById('dyes');
        const errorText = document.getElementById('dyesError');
        const valueLength = dyesInput.value.trim().length;

        if (valueLength < 2 || valueLength > 20) {
            errorText.style.display = 'block';
            dyesInput.classList.add('is-invalid');
        } else {
            errorText.style.display = 'none';
            dyesInput.classList.remove('is-invalid');
        }
    }

    // Final submit (optional, if you have a form submit button)
    function validateForm() {
        // You can include additional Step 2 validations here if needed
        validateUsage();
        validateDyes();

        const isUsageValid = !document.getElementById('usage').classList.contains('is-invalid');
        const isDyesValid = !document.getElementById('dyes').classList.contains('is-invalid');

        return isUsageValid && isDyesValid;
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const closeBtn = document.querySelector('.btn-close');

    // Change the background image to a white or red SVG close icon
    if (closeBtn) {
        const color = 'white'; // Change to 'red' if you want red icon
        const encodedColor = color === 'red' ? '%23ff0000' : '%23ffffff';

        closeBtn.style.backgroundImage =
            "url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='" + encodedColor + "' viewBox='0 0 16 16'%3E%3Cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3E%3C/svg%3E\")";

        closeBtn.style.filter = 'none'; // Remove Bootstrap filter
        closeBtn.style.opacity = '1'; // Make it fully visible
    }
});
</script>

@endsection
