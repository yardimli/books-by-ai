<!DOCTYPE html>
<html lang="tr">
<head>
	<title>{{__('default.Books By AI')}} - @yield('title', 'Home')</title>
	
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="fictionfusion.io">
	<meta name="description"
	      content="{{__('default.Books By AI')}} - {{__('default.Boilerplate Site Tagline')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<script src="/assets/js/core/jquery.min.js"></script>
	
	<!-- Favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	
	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
	@stack('google-fonts')
	
	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="/assets/vendor/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="/assets/vendor/choices/css/choices.min.css">
	
	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/custom.css">

</head>
@php
	use Carbon\Carbon;
@endphp

<script>
	
	// <!-- Dark mode -->
	const storedTheme = localStorage.getItem('theme')
	
	const getPreferredTheme = () => {
		if (storedTheme) {
			return storedTheme
		}
		return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
	}
	
	const setTheme = function (theme) {
		if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
			document.documentElement.setAttribute('data-bs-theme', 'dark')
		} else {
			document.documentElement.setAttribute('data-bs-theme', theme)
		}
	}
	
	setTheme(getPreferredTheme())
	
	window.addEventListener('DOMContentLoaded', () => {
		var el = document.querySelector('.theme-icon-active');
		if (el != 'undefined' && el != null) {
			const showActiveTheme = theme => {
				const activeThemeIcon = document.querySelector('.theme-icon-active use')
				const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
				const svgOfActiveBtn = btnToActive.querySelector('.mode-switch use').getAttribute('href')
				
				document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
					element.classList.remove('active')
				})
				
				btnToActive.classList.add('active')
				activeThemeIcon.setAttribute('href', svgOfActiveBtn)
			}
			
			window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
				if (storedTheme !== 'light' || storedTheme !== 'dark') {
					setTheme(getPreferredTheme())
				}
			})
			
			showActiveTheme(getPreferredTheme())
			
			document.querySelectorAll('[data-bs-theme-value]')
				.forEach(toggle => {
					toggle.addEventListener('click', () => {
						const theme = toggle.getAttribute('data-bs-theme-value')
						localStorage.setItem('theme', theme)
						setTheme(theme)
						showActiveTheme(theme)
					})
				})
			
		}
		
		
		const modeSwitcher = document.getElementById('modeSwitcher');
		const lightModeIcon = document.getElementById('lightModeIcon');
		const darkModeIcon = document.getElementById('darkModeIcon');
		
		// Set initial icon state
		if (getPreferredTheme() === 'dark') {
			lightModeIcon.classList.remove('d-none');
			darkModeIcon.classList.add('d-none');
		} else {
			lightModeIcon.classList.add('d-none');
			darkModeIcon.classList.remove('d-none');
		}
		
		modeSwitcher.addEventListener('click', () => {
			const currentTheme = document.documentElement.getAttribute('data-bs-theme');
			const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
			
			// Update theme
			localStorage.setItem('theme', newTheme);
			setTheme(newTheme);
			
			// Toggle icons
			lightModeIcon.classList.toggle('d-none');
			darkModeIcon.classList.toggle('d-none');
		});
	});
</script>


@if (Auth::check())
	@php
		$found_package = false;
	@endphp
@endif

<body>

<!-- =======================
Header START -->
<header class="navbar-light fixed-top header-static bg-mode">
	
	<!-- Logo Nav START -->
	<nav class="navbar navbar-expand-lg">
		<div class="container">
			<!-- Logo START -->
			<a class="navbar-brand" href="{{route('landing-page')}}">
				<img class="light-mode-item navbar-brand-item" src="/images/logo.png" alt="logo">
				<img class="dark-mode-item navbar-brand-item" src="/images/logo.png" alt="logo">
			</a>
			<!-- Logo END -->
			
			<!-- Responsive navbar toggler -->
			<button class="navbar-toggler ms-auto icon-md btn btn-light p-0" type="button" data-bs-toggle="collapse"
			        data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
			        aria-label="Toggle navigation">
        <span class="navbar-toggler-animation">
          <span></span>
          <span></span>
          <span></span>
        </span>
			</button>
			
			<!-- Main navbar START -->
			<div class="collapse navbar-collapse" id="navbarCollapse">
				
				<ul class="navbar-nav navbar-nav-scroll ms-auto">
					{{--					<li class="nav-item">--}}
					{{--						<a class="nav-link active" href="{{route('chat')}}">{{__('default.Chat')}}</a>--}}
					{{--					</li>--}}
					{{--					<li class="nav-item">--}}
					{{--						<a class="nav-link" href="{{route('articles.index')}}">{{__('default.Blog')}}</a>--}}
					{{--					</li>--}}
					
					{{--					<li class="nav-item">--}}
					{{--						<a class="nav-link" href="{{route('help-page')}}">{{__('default.Help')}}</a>--}}
					{{--					</li>--}}
					
					<li class="nav-item">
						<a class="nav-link" href="{{route('my-books')}}"><img class="me-2 h-20px"
						                                                      src="/assets/images/icon/book-outline-filled.svg"
						                                                      alt="">
							{{__('default.My Books')}}</a>
					</li>
				
				
				</ul>
			</div>
			<!-- Main navbar END -->
			
			<!-- Nav right START -->
			<ul class="nav flex-nowrap align-items-center ms-sm-3 list-unstyled">
				
				<!-- Mode Switch Button START -->
				<li class="nav-item ms-2">
					<button type="button" class="nav-link icon-md btn btn-light p-0" id="modeSwitcher">
						<!-- Sun icon for dark mode -->
						<i class="bi bi-sun fs-6 d-none" id="lightModeIcon"></i>
						<!-- Moon icon for light mode -->
						<i class="bi bi-moon-stars fs-6" id="darkModeIcon"></i>
					</button>
				</li>
				<!-- Mode Switch Button END -->
				
				<li class="nav-item ms-2 dropdown">
					<a class="nav-link btn icon-md p-0" href="#" id="profileDropdown" role="button"
					   data-bs-auto-close="outside"
					   data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
						@if (Auth::user())
							<img class="avatar-img rounded-circle"
							     src="{{ !empty(Auth::user()->avatar) ? Storage::url(Auth::user()->avatar) : '/assets/images/avatar/01.jpg' }}"
							     alt="avatar">
						@else
							<img class="avatar-img rounded-2" src="/assets/images/avatar/placeholder.jpg" alt="">
						@endif
					</a>
					<ul class="dropdown-menu dropdown-animation dropdown-menu-end pt-3 small me-md-n3"
					    aria-labelledby="profileDropdown">
						<!-- Profile info -->
						@if (Auth::user())
							<li class="px-3">
								<div class="d-flex align-items-center position-relative">
									<!-- Avatar -->
									<div class="avatar me-3">
										<img class="avatar-img rounded-circle"
										     src="{{ !empty(Auth::user()->avatar) ? Storage::url(Auth::user()->avatar) : '/assets/images/avatar/01.jpg' }}"
										     alt="avatar">
									</div>
									<div>
										<a class="h6 stretched-link"
										   href="{{route('settings.account')}}">{{ Auth::user()->name }}</a>
										<p class="small m-0">{{ Auth::user()->username }}</p>
									</div>
								</div>
								<a class="dropdown-item btn btn-primary-soft btn-sm my-2 text-center"
								   href="{{ route('orders.index') }}">
									{{ __('default.My Orders') }}
								</a>
								@if (auth()->user()->is_admin)
									<a class="dropdown-item btn btn-primary-soft btn-sm my-2 text-center"
									   href="{{ route('settings.account') }}">{{ __('Images') }}</a>
								@endif
							</li>
							<a class="dropdown-item" href="{{route('settings.account')}}"><i
									class="bi bi-person  me-2"></i>{{__('default.Settings')}}</a>
						@endif
						<!-- Links -->
						{{--						<li class="dropdown-divider"></li>--}}
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
						@if (Auth::user())
							<li><a class="dropdown-item bg-danger-soft-hover" href="#"
							       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
										class="bi bi-power  me-2"></i>Sign Out</a></li>
						@else
							<li><a class="dropdown-item bg-primary-soft-hover" href="{{ route('login') }}"><i
										class="bi bi-unlock  me-2"></i>{{__('default.Sign in')}}</a></li>
							<li><a class="dropdown-item bg-primary-soft-hover" href="{{ route('register') }}"><i
										class="bi bi-person-circle  me-2"></i>{{__('default.Register')}}</a></li>
						@endif
						<!-- Dark mode options START -->
						<hr class="dropdown-divider">
				
				</li>
				<!-- Dark mode options END-->
			</ul>
			</li>
			<!-- Profile START -->
			
			</ul>
			<!-- Nav right END -->
		</div>
	</nav>
	<!-- Logo Nav END -->
</header>
<!-- =======================
Header END -->


@yield('content')

<!-- =======================
JS libraries, plugins and custom scripts -->

<!-- Bootstrap JS -->
<script src="/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="/assets/vendor/tiny-slider/tiny-slider.js"></script>

<script src="/assets/vendor/choices/js/choices.min.js"></script>

<!-- Theme Functions -->
<script src="/assets/js/functions.js"></script>

@php($title = View::getSection('title', 'Home'))

@stack('scripts')

</body>
</html>
