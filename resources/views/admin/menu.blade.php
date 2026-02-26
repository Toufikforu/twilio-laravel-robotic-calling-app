	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="#">
          			<span class="align-middle">Admin Dashboard</span>
        		</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Admin Area
					</li>

					<li class="sidebar-item {{ (request()->is('admin/dashboard')) ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('admindashboard')}}">
							<i class="fa-solid fa-house"></i> <span class="align-middle">Dashboard</span>
						</a>
					</li>
					
					<li class="sidebar-item {{ (request()->is('admin/all-user')) ? 'active' : ''}}">
						<a class="sidebar-link" href="{{route('alluser')}}">
							<i class="fa-solid fa-house"></i> <span class="align-middle">All User</span>
						</a>
					</li>
					
					

				
					
					<li class="sidebar-header">
						My Account
					</li>
					
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{route('logout')}}" 
								onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							<i class="fa-sharp fa-solid fa-right-from-bracket"></i> <span class="align-middle">{{ __('Logout') }}</span>
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
							@csrf
						</form>
					</li>

				</ul>


			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>
			</nav>


			<main class="content">
				@yield('content')
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<x-copyright/>
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="#" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="#" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>