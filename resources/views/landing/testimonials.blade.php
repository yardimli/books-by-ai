<section class="testimonial-responsive-padding-top bg-light">
	<div class="container">
		<h2 class="text-center mb-4">{{ __('default.testimonials.heading') }}</h2>
		<div class="main-carousel" style="max-width: 700px; margin:0 auto;">
			@foreach(__('default.testimonials.reviews') as $review)
				<div class="carousel-cell">
					<div class="d-flex justify-content-center">
						<div class="testimonial-card">
							<div class="card h-100 border-0 shadow-sm">
								<img src="{{ $review['image'] }}" class="card-img-top" alt="Customer Review">
								<div class="card-body text-center">
									<p class="card-text inria-serif-regular">"{{ $review['text'] }}"</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<style>
    .carousel-cell {
        width: 220px;
		    min-height: 300px;
        margin-left:10px;
        margin-right: 10px;
    }
    .card-img-top {
        width: 220px;
        min-width: 220px;
        max-height: 220px;
        object-fit: cover;
    }
    .card-body {
        min-height: 90px;
    }
    .card-text {
        font-style: italic;
        font-weight: bold;
        font-size: 14px;
    }

    .testimonial-responsive-padding-top {
        padding-top: 40px;
		    padding-bottom: 40px;
    }

    @media (max-width: 768px) {
        .testimonial-responsive-padding-top {
            padding-top: 30px;
        }
    }
</style>

@push('scripts')
	<script>
		$(document).ready(function () {
			$('.main-carousel').flickity({
				// options
				cellAlign: 'left',
				contain: true,
				wrapAround: true,
				autoPlay: true,
				autoPlay: 5000,
				prevNextButtons: true,
			});
		});
	</script>
@endpush
