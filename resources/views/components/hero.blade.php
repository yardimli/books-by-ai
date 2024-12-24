<section class="hero-responsive-padding-top pb-3 mt-5">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 mb-3">
				<h1>{{ __('default.hero.title') }}</h1>
				<p class="lead inria-serif-regular">{{ __('default.hero.subtitle') }}</p>
				<a href="{{route('create-book')}}" class="btn btn-lg btn-primary d-none d-lg-inline-block">{{ __('default.hero.cta') }}</a>
			</div>
			<div class="col-lg-6 mb-3">
				<img src="/images/hero-image.webp" alt="{{ __('default.hero.title') }}" class="img-fluid hero-image">
			</div>
		</div>
	</div>
</section>

<style>
    .hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }
    
    .hero-responsive-padding-top {
		    				padding-top: 50px;
    }

    @media (max-width: 768px) {
		    .hero-responsive-padding-top {
		    				padding-top: 30px;
		    }
    }
</style>
