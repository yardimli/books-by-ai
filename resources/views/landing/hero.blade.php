<section class="hero-responsive-padding-top pb-5 mt-5 overflow-hidden"> {{-- Added overflow-hidden --}}
	<div class="container position-relative"> {{-- Added position-relative --}}
		{{-- Optional: Add a subtle background blob/shape --}}
		{{-- <div class="hero-background-shape"></div> --}}
		<div class="row align-items-center">
			<div class="col-lg-6 mb-4 mb-lg-0 text-center text-lg-start" style="z-index: 2;"> {{-- Added z-index --}}
				<h1 class="display-4 fw-bold mb-3">{{ __('default.hero.title') }}</h1> {{-- Made heading bigger --}}
				<p class="lead inria-serif-regular mb-4">{{ __('default.hero.subtitle') }}</p>
				<a href="{{route('create-book')}}" class="btn btn-lg btn-primary px-5 py-3">{{ __('default.hero.cta') }}</a> {{-- Larger CTA --}}
			</div>
			<div class="col-lg-6 mb-3 text-center">
				{{-- Make image overlap slightly or tilt --}}
				<img src="/images/herkes-yazar-1.jpg" alt="{{ __('default.hero.title') }}" class="img-fluid hero-image shadow-lg" style="transform: rotate(2deg); max-width: 90%; margin-left: -5%;"> {{-- Added style --}}
			</div>
		</div>
	</div>
</section>

<style>
    .hero-image {
        /* width: 100%; */ /* Let max-width handle it */
        /* height: 100%; */ /* Let image aspect ratio work */
        object-fit: cover;
        border-radius: 15px; /* Slightly more rounded */
        /* transform: rotate(2deg); */ /* Moved inline for example */
        /* max-width: 90%; */ /* Moved inline */
        /* margin-left: -5%; */ /* Pull slightly left for overlap effect on larger screens */
    }

    .hero-responsive-padding-top {
        padding-top: 60px; /* Increased padding */
    }

    /* Optional background shape example */
    /*
		.hero-background-shape {
				position: absolute;
				top: -50px;
				left: -100px;
				width: 400px;
				height: 400px;
				background-color: rgba(var(--bs-primary-rgb), 0.1);
				border-radius: 50% 60% 40% 70% / 60% 40% 70% 50%;
				z-index: 0;
				filter: blur(50px);
		}
		*/

    @media (max-width: 991.98px) {
        .hero-image {
            transform: rotate(0deg); /* Straighten on smaller screens */
            margin-left: 0;
            max-width: 100%;
        }
        .hero-responsive-padding-top {
            padding-top: 30px;
        }
    }
</style>
