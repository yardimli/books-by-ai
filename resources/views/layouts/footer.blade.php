<!-- footer START -->
<footer class="bg-mode">
	<section class="py-5 bg-light">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h3>Books by AI</h3>
					<ul class="list-unstyled">
						<li>
							<a class="nav-link" href="{{route('about-page')}}"><i
									class="bi bi-info-circle  me-2"></i>{{__('default.About')}}</a>
						</li>
						<li><a class="nav-link" href="{{route('help-page')}}"><i
									class="bi bi-exclamation-circle  me-2"></i>{{__('default.Help')}}</a></li>
						<li><a class="nav-link" href="{{route('terms-page')}}"><i
									class="bi bi-check-all  me-2"></i>{{__('default.Terms')}}</a></li>
						<li><a class="nav-link" href="{{route('privacy-page')}}"><i
									class="bi bi-list  me-2"></i>{{__('default.Privacy')}}</a></li>
						<li>
							<div class="dropup mt-0">
								<a class="dropdown-toggle nav-link" href="{{ route('landing-page') }}" role="button"
								   id="languageSwitcher" data-bs-toggle="dropdown" aria-expanded="false">
									<i class="bi bi-globe  me-2"></i>{{__('default.Language')}}
								</a>
								<ul class="dropdown-menu min-w-auto" aria-labelledby="languageSwitcher">
									<li><a class="dropdown-item me-4" href="{{ route('changeLang') }}?lang=en_US"><img
												class="me-2" style="width: 20px;" src="/assets/images/flags/uk.svg"
												alt="">{{__('default.English')}}
										</a></li>
									<li><a class="dropdown-item me-4" href="{{ route('changeLang') }}?lang=tr_TR"><img
												class="me-2" style="width: 20px;" src="/assets/images/flags/tr.svg"
												alt="">{{__('default.Turkish')}}
										</a></li>
								</ul>
							</div>
						</li>
					</ul>
					<div class="social-links">
						<!-- Add social media links -->
					</div>
				</div>
				<div class="col-md-6">
					<h3>Need some help?</h3>
					<p>Our dedicated customer support team is available to help</p>
					<button class="btn btn-dark">Contact us</button>
					
					<p class="mt-3">©2024 <a class="text-body"
					                                                 href="https://www.my-laravel-saas-site.com"> {{__('default.Books By AI')}}
				</div>
			</div>
		</div>
	</section>
</footer>
<!-- footer END -->


@include('layouts.modals')

<?php
