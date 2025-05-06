<section class="py-5 bg-light">
	<div class="container">
		<h2 class="text-center mb-2 fw-bold">{{ __('default.cover_options.title') }}</h2>
		<p class="step-description text-center inria-serif-regular mb-5">{{ __('default.cover_options.description') }}</p>
		<div class="row justify-content-center align-items-center">
			{{-- Paperback Option --}}
			<div class="col-md-5 col-lg-4 text-center mb-4 mb-md-0">
				<img src="/images/paperback.jpg" alt="{{ __('default.cover_options.paperback.title') }}" class="cover-option-image shadow" style="transform: rotate(-3deg);">
				<div class="mt-3">
					<h4 class="inria-serif-regular mb-1">{{ __('default.cover_options.paperback.title') }}</h4>
					<p class="mb-0 inria-serif-regular text-muted">{{ __('default.cover_options.paperback.description') }}</p>
				</div>
			</div>
			{{-- Hardcover Option --}}
			<div class="col-md-5 col-lg-4 text-center">
				<img src="/images/big-paperback.jpg" alt="{{ __('default.cover_options.hardcover.title') }}" class="cover-option-image shadow" style="transform: rotate(3deg);">
				<div class="mt-3">
					<h4 class="inria-serif-regular mb-1">{{ __('default.cover_options.hardcover.title') }}</h4>
					<p class="mb-0 inria-serif-regular text-muted">{{ __('default.cover_options.hardcover.description') }}</p>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
    .cover-option-image {
        width: 100%;
        max-width: 220px; /* Control max size */
        height: auto;
        object-fit: cover;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .cover-option-image:hover {
        transform: scale(1.05) rotate(0deg) !important; /* Enlarge and straighten */
    }

    /* Remove card styles if they existed */
    /*
		.cover-option .card { background: transparent; border: none; }
		.cover-image-wrapper { width: 200px; height: 200px; margin: 0 auto; }
		.cover-image { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; }
		.cover-options-text-center { text-align: center; }
		*/

    @media (max-width: 767.98px) {
        .cover-option-image {
            max-width: 180px; /* Smaller on mobile */
            transform: rotate(0deg) !important; /* Straighten */
        }
    }
</style>
