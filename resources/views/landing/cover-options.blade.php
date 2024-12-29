<section class="pt-5 bg-light">
	<div class="container">
		<h2 class="text-center mb-2">{{ __('default.cover_options.title') }}</h2>
		<p class="step-description text-center inria-serif-regular mb-4">{{ __('default.cover_options.description') }}</p>
		
		<div class="row justify-content-center">
			<div class="d-flex justify-content-center gap-4 flex-wrap">
				<div class="cover-option">
					<div class="card border-0">
						<div class="cover-image-wrapper">
							<img src="/images/paperback.jpg" alt="13x19,5 cm" class="cover-image">
						</div>
						<div class="card-body cover-options-text-center">
							<h4 class="inria-serif-regular">{{ __('default.cover_options.paperback.title') }}</h4>
							<p class="mb-0 inria-serif-regular">{{ __('default.cover_options.paperback.description') }}</p>
						</div>
					</div>
				</div>
				<div class="cover-option">
					<div class="card border-0">
						<div class="cover-image-wrapper">
							<img src="/images/big-paperback.jpg" alt="Hardcover" class="cover-image">
						</div>
						<div class="card-body cover-options-text-center">
							<h4 class="inria-serif-regular">{{ __('default.cover_options.hardcover.title') }}</h4>
							<p class="mb-0 inria-serif-regular">{{ __('default.cover_options.hardcover.description') }}</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
    .cover-option .card {
        background: transparent;
    }

    .cover-image-wrapper {
        width: 200px;
        height: 200px;
        margin: 0 auto;
    }

    .cover-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 12px;
    }
    
    .cover-options-text-center {
		    				text-align: center;
    }

    @media (max-width: 768px) {
        .cover-image-wrapper {
            width: 150px;
            height: 150px;
        }
		    .card-body {
						padding-left: 0px;
				    padding-right: 0px;
				}
		    .cover-options-text-center {
				    		    				text-align: left !important;
		    }
		  
    }
</style>
