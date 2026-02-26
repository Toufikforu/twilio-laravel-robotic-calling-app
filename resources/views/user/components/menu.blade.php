<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar bg-dark">
				<x-logo/>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Main Area
					</li>

					<li class="sidebar-item {{ (request()->is('user/dashboard')) ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('userdashboard')}}">
							<i class="fa-solid fa-house"></i> <span class="align-middle">Dashboard</span>
						</a>
					</li>


					
						<li class="sidebar-item {{ (request()->is('user/uploadcsv')) ? 'active' : ''}}">
							<a class="sidebar-link" href="{{route('uploadcsv.index')}}">
								<i class="fa-solid fa-palette"></i> 

								<span class="align-middle">Upload CSV</span>
							</a>
						</li>
					
						<li class="sidebar-item {{ (request()->is('user/scripts')) ? 'active' : ''}}">
							<a class="sidebar-link" href="{{route('scripts.index')}}">
								<i class="fa-solid fa-palette"></i> 

								<span class="align-middle">Scripts</span>
							</a>
						</li>
						
						
						
						<li class="sidebar-item {{ (request()->is('user/campaigns')) ? 'active' : ''}}">
							<a class="sidebar-link" href="{{route('campaigns.index')}}">
								<i class="fa-solid fa-palette"></i> 

								<span class="align-middle">Campaigns</span>
							</a>
						</li>
						
						<li class="sidebar-item {{ (request()->is('user/calllogs')) ? 'active' : ''}}">
							<a class="sidebar-link" href="{{route('calllogs')}}">
								<i class="fa-solid fa-palette"></i> 

								<span class="align-middle">Call Logs</span>
							</a>
						</li>
												


					<li class="sidebar-header">
						My Account
					</li>
				
					<li class="sidebar-item {{ (request()->is('user/profile')) ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('profile')}}">
							<i class="fa-regular fa-address-card"></i> <span class="align-middle">Profile</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							<i class="fa-sharp fa-solid fa-right-from-bracket"></i> <span class="align-middle">{{ __('Logout') }}</span>
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</li>

					<li class="sidebar-header">
						Documentation
					</li>

					<li class="sidebar-item {{ (request()->is('user/how-to-use')) ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('use')}}">
							<i class="fa-solid fa-screwdriver-wrench"></i> <span class="align-middle">How to use</span>
						</a>
					</li>
					<li class="sidebar-item {{ (request()->is('user/flow-us')) ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('flowus')}}">
							<i class="fa-solid fa-share"></i> <span class="align-middle">Follow us</span>
						</a>
					</li>


				</ul>


			</div>
		</nav> 
		<!-- Left side bar End  -->

		<!-- User Profile dropdown right menu  -->
		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Welcome! <span class="brand-text">{{ Auth::user()->name }}</span>
							</a>

							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{route('profile')}}"><i class="align-middle me-1" data-feather="user"></i>Profile</a>
								<a class="dropdown-item" href="{{route('privacy')}}"><i class="align-middle me-1" data-feather="settings"></i> Privacy</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="{{route('help')}}"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="logout">
									<a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
										<i class="fa-sharp fa-solid fa-right-from-bracket"></i> <span class="align-middle">{{ __('Logout') }}</span>
									</a>

									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form>
								</div>
							</div>
							

							
						</li>
					</ul>
				</div>
			</nav>
		


