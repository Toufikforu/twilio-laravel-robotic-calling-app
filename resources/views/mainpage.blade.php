<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('user/img/favicon.png')}}" />
    <title>Carpet Dyeing Traing | Dyebold</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero {
            position: relative;
            text-align: center;
            padding: 60px 20px;
            background: url("{{ asset('user/img/Hotel_Carpet_Dyeing_Dyebold.gif') }}") no-repeat center center fixed;
            background-size: cover;
            color: white;
        }

        .hero::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Adjust the overlay color and opacity */
            z-index: 1;
        }

        .hero * {
            position: relative;
            z-index: 2; /* Ensures text and other content appear above the overlay */
        }

        .video-section {
            text-align: center;
            padding: 40px 20px;
        }


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
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Dark overlay */
    z-index: 1;
}

.info-section * {
    position: relative;
    z-index: 2; /* Ensures content appears above overlay */
}

        .btn-custom {
            width: 150px;
            margin: 10px;
        }
        .dyebold-color{
            background-color: #570101 !important;
            border: 1px solid #570101;
        }

        .result-box {
            width: 100%;
            height: 50px;
            margin: 20px 0px;
            border: 1px solid #ccc;
        }
        #image-area, #rang-area i{
            display:none;
        }
        .card-header, #nonebox, .btn-upload {
           display: none;
        }

        /* ===== Register Model Pop up Style */
        .modal-content {
            background-color: #000; /* Modal background black */
        }
        .form-label,label.col-md-4.col-form-label {
            font-weight: bold;
            color: #ddc27a; /* Branding color */
        }
        .form-check-label {
            color: #fff; /* White text for checkbox labels */
        }
        .btn-check:focus+.btn-danger, .btn-danger:focus {
            color: #fff;
            background-color: #bb2d3b;
            border-color: #b02a37;
            box-shadow: 0 0 0 .25rem rgba(225, 83, 97, .5);
        }
        .modal-header .btn-close {
            filter: invert(1);
            opacity: 1;
        }
    </style>


    </styl>
</head>
<body>

    <!-- Header Section -->
    <div class="hero">
        <h1>Master the Art of Carpet Dyeing!</h1>
        <p>Learn professional carpet dyeing techniques and restore colors like a pro</p>
    </div>

    <!-- Buttons Section -->
    <div class="container text-center mt-4">
        <a href="{{ route('login') }}" class="btn btn-primary btn-custom dyebold-color">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success btn-custom dyebold-color">Free Registration</a>

        <!-- Create Register Pop up Form March 25 start -->
         <!-- Button to Open Modal -->
        <!-- <button type="button" class="btn btn-primary dyebold-color" data-bs-toggle="modal" data-bs-target="#multiStepModal">
            Free Registration
        </button> -->
        <!-- Button to Open Modal -->
        <!-- Multi-Step Modal -->
            <form method="POST" action="{{ route('register') }}">
                <div class="modal fade" id="multiStepModal" tabindex="-1" aria-labelledby="multiStepModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-white" id="modalTitle">Step 1: Answer Questions</h5>
                                <button type="button" class="btn-close btn-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <!-- Step 1: Questions -->
                                <div id="step1">
                                        <!-- Usage field -->
                                        <div class="mb-3">
                                            <label for="usage" class="form-label d-block text-start">
                                                1. So we can best serve the community, how will you use the Dyebold App? (Be specific)<span class="text-danger">*</span>
                                            </label>
                                            <textarea 
                                                id="usage" 
                                                class="form-control" 
                                                name="usage" 
                                                maxlength="100" 
                                                placeholder="Max 100 characters" 
                                                style="height: 80px;" 
                                                oninput="validateUsage()"
                                            ></textarea>
                                            <small id="usageError" style="color: red; display: none;">
                                                Please enter at least 10 characters (max 100).
                                            </small>
                                        </div>

                                    <div class="mb-3 text-start">
                                        <label class="form-label d-block">2. Which Dye Training have you taken?<span class="text-danger">*</span></label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="training[]" id="iicrc" value="IICRC Carpet Dyeing">
                                            <label class="form-check-label" for="iicrc">IICRC Carpet Dyeing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="training[]" id="nylon" value="DyeBold Nylon Carpet Dyeing">
                                            <label class="form-check-label" for="nylon">DyeBold Nylon Carpet Dyeing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="training[]" id="polyester" value="Dyebold Polyester Carpet Dyeing">
                                            <label class="form-check-label" for="polyester">Dyebold Polyester Carpet Dyeing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="training[]" id="rug" value="Dyebold Rug Dyeing">
                                            <label class="form-check-label" for="rug">Dyebold Rug Dyeing</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="training[]" id="colorful" value="Colorful Carpets">
                                            <label class="form-check-label" for="colorful">Colorful Carpets</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="training[]" id="none" value="None but would love to!">
                                            <label class="form-check-label" for="none">None but would love to!</label>
                                        </div>
                                    </div>


                                        <!-- Dyes field -->
                                    <div class="mb-3">
                                        <label for="dyes" class="form-label d-block text-start">
                                            3. Which dyes do you currently use? <span class="text-danger">*</span>
                                        </label>
                                        <input 
                                            type="text" 
                                            id="dyes" 
                                            name="dyes" 
                                            class="form-control" 
                                            maxlength="20" 
                                            placeholder="Max 20 characters" 
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
                                                <button type="button" class="btn btn-dark " id="backStep">Back</button>
                                                <a href="{{ route('register') }}"><button type="submit" class="btn btn-primary dyebold-color">Register</button></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>  
                        </div>
                    </div>
                </div>
            </form>

		<!-- ./ Model End -->
		
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Carpet Dyeing Color Formula Demo</h2>
                        <div class="row">

                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                <img src="{{ asset('user/img/freeColor.jpg') }}" alt="" class="img-fluid">
                            </div>

                            <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                <img src="{{ asset('user/img/devices.png') }}" alt="" class="img-fluid">
                            </div>

                        </div><!-- Row Target, Current & Needed End -->
                        <!-- Image Upload, ZoomIn, Zoom Out, And Color Preview Start -->
                    </div><!-- / .card-body -->
                </div><!-- / .card -->
            </div><!-- / .col-md-12 -->
        </div><!-- / .Row -->
        <div id="image-area">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-3 col-md-3">
                            <input class="form-control" type="file" id="imgUpload">
                            <label class="btn btn-dyebold btn-upload" for="imgUpload">
                                <i class="fa fa-upload" aria-hidden="true"></i>
                            </label>
                        </div>
                        <div class="col-3 col-md-3">
                            <select class="form-control img-dropdown">
                                <option value="1.jpg">Image 1</option>
                                <option value="2.jpg">Image 2</option>
                                <option value="3.png">Image 3</option>
                            </select>
                        </div>
                        <div class="col-3 col-md-3">
                            <button class="btn btn-dyebold" id="pick-color">
                                <i class="fa fa-crosshairs" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-dyebold">
                                <i class="fa fa-search-plus" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-dyebold">
                                <i class="fa fa-search-minus" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="col-3 col-md-3">
                            <div class="bg-preview"></div>
                        </div>
                    </div><!-- / .Row -->
                </div><!-- / .card-header -->
            </div><!-- / .card -->
        </div><!-- / .Image-area -->
    </div><!-- / .container -->
    <!-- Container only -->


    <!-- Video Gallery Section -->
    <div class="container text-center my-5">
        <h3>Video Gallery</h3>
        <div class="row">
           
            <div class="col-md-4 mb-4">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/pjf8sNjgbX4" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/tCXHYVuI4r4" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.youtube.com/embed/RcB4oJjwpA8" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Section -->
    <div class="info-section">
        <h3>Why Choose Dyebold?</h3>
        <p>We provide the best solutions for your needs. Join us and be part of something amazing.</p>
        <a href="https://dyebold.com/" class="btn btn-dark dyebold-color">Learn More</a>
    </div>



    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

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


    
</body>
</html>
