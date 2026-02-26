<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('user/img/favicon.png')}}" />
    <title>Robotic Calling App Demo | Twilio Calling App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <style>
        body { background-color: #f8f9fa; }

        .hero {
            position: relative;
            text-align: center;
            padding: 60px 20px;
            /* Use your own background image if you want */
            background: url("{{ asset('user/img/bg-main.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: 1;
        }

        .hero * { position: relative; z-index: 2; }

        .video-section { text-align: center; padding: 40px 20px; }

        .info-section {
            position: relative;
            padding: 40px 20px;
            text-align: center;
            background: url("{{ asset('user/img/bg-main.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .info-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .info-section * { position: relative; z-index: 2; }

        .btn-custom { width: 150px; margin: 10px; }

        .dyebold-color {
            background-color: #570101 !important;
            border: 1px solid #570101;
        }

        /* Hide unused UI from original template */
        .result-box { width: 100%; height: 50px; margin: 20px 0px; border: 1px solid #ccc; }
        #image-area, #rang-area i { display:none; }
        .card-header, #nonebox, .btn-upload { display: none; }

        /* ===== Register Model Pop up Style */
        .modal-content { background-color: #000; }
        .form-label, label.col-md-4.col-form-label { font-weight: bold; color: #ddc27a; }
        .form-check-label { color: #fff; }
        .btn-check:focus+.btn-danger, .btn-danger:focus {
            color: #fff;
            background-color: #bb2d3b;
            border-color: #b02a37;
            box-shadow: 0 0 0 .25rem rgba(225, 83, 97, .5);
        }
        .modal-header .btn-close { filter: invert(1); opacity: 1; }
    </style>
</head>

<body>

<!-- Header Section -->
<div class="hero">
    <h1>Twilio Robotic Calling App</h1>
    <p>Automate outbound calls, manage contacts, and track call outcomes — all from one dashboard.</p>
</div>

<!-- Buttons Section -->
<div class="container text-center mt-4">
    <a href="{{ route('login') }}" class="btn btn-primary btn-custom dyebold-color">Login</a>
    <a href="{{ route('register') }}" class="btn btn-success btn-custom dyebold-color">Free Registration</a>

    <!-- Multi-Step Modal (kept, but text changed to calling app context) -->
    <form method="POST" action="{{ route('register') }}">
        <div class="modal fade" id="multiStepModal" tabindex="-1" aria-labelledby="multiStepModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-white" id="modalTitle">Step 1: Quick Questions</h5>
                        <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Step 1: Questions -->
                        <div id="step1">
                            <div class="mb-3">
                                <label for="usage" class="form-label d-block text-start">
                                    1. How will you use the Robotic Calling App? (Be specific)<span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="usage"
                                    class="form-control"
                                    name="usage"
                                    maxlength="100"
                                    placeholder="Example: appointment reminders, lead follow-ups, payment alerts (max 100 chars)"
                                    style="height: 80px;"
                                    oninput="validateUsage()"
                                ></textarea>
                                <small id="usageError" style="color: red; display: none;">
                                    Please enter at least 10 characters (max 100).
                                </small>
                            </div>

                            <div class="mb-3 text-start">
                                <label class="form-label d-block">2. What type of calls do you plan to run?<span class="text-danger">*</span></label>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="training[]" id="reminders" value="Appointment Reminders">
                                    <label class="form-check-label" for="reminders">Appointment Reminders</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="training[]" id="leads" value="Lead Follow-ups">
                                    <label class="form-check-label" for="leads">Lead Follow-ups</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="training[]" id="support" value="Customer Support Callbacks">
                                    <label class="form-check-label" for="support">Customer Support Callbacks</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="training[]" id="payments" value="Payment Reminders">
                                    <label class="form-check-label" for="payments">Payment Reminders</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="training[]" id="surveys" value="Surveys / Feedback Calls">
                                    <label class="form-check-label" for="surveys">Surveys / Feedback Calls</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="training[]" id="none" value="Not sure yet">
                                    <label class="form-check-label" for="none">Not sure yet</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="dyes" class="form-label d-block text-start">
                                    3. Which calling provider do you use today? <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="dyes"
                                    name="dyes"
                                    class="form-control"
                                    maxlength="20"
                                    placeholder="Example: Twilio (max 20 chars)"
                                    style="height: 40px;"
                                    oninput="validateDyes()"
                                >
                                <small id="dyesError" style="color: red; display: none;">
                                    Please enter at least 2 characters (max 20).
                                </small>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary dyebold-color" id="nextStep">Next</button>
                            </div>
                        </div>

                        <!-- Step 2: Registration -->
                        <div id="step2" style="display: none;">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Name<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="company" class="col-md-4 col-form-label text-md-end">Company<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="company" type="text" class="form-control" name="company" value="{{ old('company') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">Role<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="role" type="text" class="form-control" name="role" value="{{ old('role') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email Address<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Password<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-dark" id="backStep">Back</button>
                                        <button type="submit" class="btn btn-primary dyebold-color">Register</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- / modal-body -->
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Main Content -->
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center">Robotic Calling Dashboard Demo</h2>
                    <p class="text-center mb-4">
                        See how to upload contacts, launch a calling campaign, and track call status in real-time.
                    </p>

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <div class="ratio ratio-16x9">
                                <!-- Replace this with your demo video URL -->
                                <iframe
                                    src="https://www.youtube.com/embed/YOUR_DEMO_VIDEO_ID"
                                    title="Robotic Calling App Demo"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Tip: Replace <code>YOUR_DEMO_VIDEO_ID</code> with your actual demo video ID.
                            </small>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="p-3 bg-light rounded border h-100 text-start">
                                <h5 class="mb-3"><i class="fa-solid fa-bolt"></i> What you can do</h5>
                                <ul class="mb-0">
                                    <li>Create call campaigns and schedules</li>
                                    <li>Import contacts and segment lists</li>
                                    <li>Trigger calls via Twilio and capture outcomes</li>
                                    <li>Log call status (answered, no-answer, voicemail, failed)</li>
                                    <li>View analytics and call history</li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- /row -->
                </div><!-- /card-body -->
            </div><!-- /card -->
        </div><!-- /col -->
    </div><!-- /row -->
</div>

<!-- Video Gallery Section -->
<div class="container text-center my-5">
    <h3>Demo Videos</h3>
    <p class="text-muted">Short walkthroughs of campaigns, contact import, and reporting.</p>

    <div class="row">
        <!-- Replace these URLs with your demo video URLs -->
        <div class="col-md-4 mb-4">
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_1" title="Demo Video 1" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_2" title="Demo Video 2" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_3" title="Demo Video 3" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<!-- Information Section -->
<div class="info-section">
    <h3>Why Use This Robotic Calling App?</h3>
    <p>
        Launch automated outbound calls with Twilio, reduce manual calling effort, and keep a complete audit trail of every call.
        Perfect for reminders, lead follow-ups, notifications, and support callbacks.
    </p>
    <a href="{{ url('/login') }}" class="btn btn-dark dyebold-color">Get Started</a>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById("nextStep").addEventListener("click", function () {
        validateUsage();
        validateDyes();

        const isUsageValid = !document.getElementById('usage').classList.contains('is-invalid');
        const isDyesValid  = !document.getElementById('dyes').classList.contains('is-invalid');

        if (isUsageValid && isDyesValid) {
            document.getElementById("step1").style.display = "none";
            document.getElementById("step2").style.display = "block";
            document.getElementById("modalTitle").innerText = "Step 2: Register";
        } else {
            const firstError = document.querySelector('.is-invalid');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth' });
        }
    });

    document.getElementById("backStep").addEventListener("click", function () {
        document.getElementById("step2").style.display = "none";
        document.getElementById("step1").style.display = "block";
        document.getElementById("modalTitle").innerText = "Step 1: Quick Questions";
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
</script>

</body>
</html>