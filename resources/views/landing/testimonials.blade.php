<section class="testimonial-section py-5" style="background: linear-gradient(175deg, #f8f9fa 85%, #ffffff 100%);"> {{-- Changed background --}}
	<div class="container">
		<h2 class="text-center mb-5 fw-bold">{{ __('default.testimonials.heading') }}</h2> {{-- Increased bottom margin --}}
		<div class="main-carousel" data-flickity='{ "cellAlign": "left", "contain": true, "wrapAround": true, "autoPlay": 5000, "prevNextButtons": false, "pageDots": true }'> {{-- Removed prev/next, added page dots --}}
			@foreach(__('default.testimonials.reviews') as $review)
				<div class="carousel-cell mx-2"> {{-- Added mx-2 for spacing --}}
					<div class="testimonial-card-funky">
						<img src="{{ $review['image'] }}" class="testimonial-image" alt="Customer Review">
						<div class="testimonial-text">
							<p class="card-text inria-serif-regular mb-0">"{{ $review['text'] }}"</p>
							{{-- Speech bubble tail --}}
							<div class="speech-bubble-tail"></div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<style>
    .carousel-cell {
        width: 250px; /* Slightly wider */
        min-height: 350px; /* Adjusted height */
        /* margin-left: 10px; */ /* Handled by mx-2 */
        /* margin-right: 10px; */ /* Handled by mx-2 */
        display: flex; /* Align items */
        align-items: center; /* Center vertically */
        justify-content: center; /* Center horizontally */
    }

    .testimonial-card-funky {
        background-color: #fff;
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        text-align: center;
        position: relative; /* Needed for absolute positioning of image */
        margin-top: 40px; /* Make space for image */
        width: 100%;
    }

    .testimonial-image {
        width: 80px; /* Smaller image */
        height: 80px;
        border-radius: 50%; /* Circular image */
        object-fit: cover;
        border: 4px solid #fff; /* White border */
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        position: absolute; /* Position over the card */
        top: -40px; /* Move image up */
        left: 50%;
        transform: translateX(-50%); /* Center the image */
        z-index: 2;
    }

    .testimonial-text {
        margin-top: 30px; /* Space below image */
        position: relative; /* For speech bubble tail */
        background-color: #f0f0f0; /* Light background for text */
        padding: 15px;
        border-radius: 10px;
    }

    .speech-bubble-tail {
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-bottom: 15px solid #f0f0f0; /* Same as text background */
        position: absolute;
        top: -14px; /* Position just above the text box */
        left: 50%;
        transform: translateX(-50%);
    }

    .card-text {
        font-style: normal; /* Remove italic */
        font-weight: 500; /* Slightly bolder */
        font-size: 15px;
        line-height: 1.5;
    }

    /* Flickity dots styling */
    .flickity-page-dots {
        bottom: -30px; /* Move dots down */
    }
    .flickity-page-dots .dot {
        background: #adb5bd; /* Grey dots */
    }
    .flickity-page-dots .dot.is-selected {
        background: var(--bs-primary); /* Primary color for selected */
    }

    @media (max-width: 768px) {
        .carousel-cell {
            width: 80%; /* Take more width on mobile */
            min-height: auto; /* Adjust height */
        }
        .testimonial-card-funky {
            margin-top: 50px; /* Ensure enough space */
        }
    }
</style>

{{-- Ensure Flickity JS is loaded in landing.blade.php or app.blade.php --}}
{{-- @push('scripts')
<script>
// Flickity initialization moved to inline data-flickity attribute
// $(document).ready(function () {
//     $('.main-carousel').flickity({
//         cellAlign: 'left',
//         contain: true,
//         wrapAround: true,
//         autoPlay: 5000,
//         prevNextButtons: false, // Hide arrows
//         pageDots: true // Show dots
//     });
// });
</script>
@endpush --}}
