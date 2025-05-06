<section class="how-it-works py-5 position-relative">
	{{-- Optional: Add a subtle background wave/pattern --}}
	{{-- <div class="how-it-works-bg"></div> --}}
	<div class="container">
		<h2 class="text-center mb-5 fw-bold">{{ __('default.how_it_works.title') }}</h2>
		
		{{-- Step 1 --}}
		<div class="row align-items-center step-row mb-5 pb-4">
			<div class="col-lg-5 text-center text-lg-start mb-4 mb-lg-0">
				<div class="step-content">
					<div class="step-number-funky">{{ __('default.how_it_works.step1.number') }}</div>
					<h4 class="inria-serif-regular mb-3">{{ __('default.how_it_works.step1.heading') }}</h4>
					<p class="step-description inria-serif-regular">{{ __('default.how_it_works.step1.description') }}</p>
				</div>
			</div>
			<div class="col-lg-6 offset-lg-1 d-flex justify-content-center">
				{{-- Make the card pop more --}}
				<div class="question-card-funky shadow-lg">
					<div class="profile-header">
						<div class="profile-img mb-2">
							<img src="/images/profile1.jpg" alt="Profile">
						</div>
						<h5 class="inria-serif-regular">{{ __('default.how_it_works.step1.profile_title') }}</h5>
					</div>
					<div class="question-form">
						<div class="question-item question-item-shadow mb-3">
							<div class="d-flex justify-content-between align-items-center mb-2">
								<span class="inria-serif-regular fw-bold small">{{ __('default.how_it_works.step1.hobby_question') }}</span>
								<i class="bi bi-pencil-square text-primary"></i>
							</div>
							<div class="answer-text inria-serif-regular small bg-light p-2 rounded">
								{{ __('default.how_it_works.step1.hobby_answer') }}
							</div>
							{{-- <button class="btn btn-dark btn-sm w-100 mt-2">{{ __('default.how_it_works.step1.save_button') }}</button> --}}
							<div class="text-center mt-2"><span class="badge bg-success">{{ __('default.how_it_works.step1.save_button') }}</span></div>
						</div>
						<div class="question-item collapsed p-2 rounded" style="background-color: #e9ecef;">
							<div class="d-flex justify-content-between align-items-center">
								<span class="inria-serif-regular small">{{ __('default.how_it_works.step1.friends_question') }}</span>
								<i class="bi bi-plus-circle"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
			{{-- Connecting Line/Arrow (Example) --}}
			<div class="step-connector step-connector-down"></div>
		</div>
		
		{{-- Step 2 --}}
		<div class="row align-items-center step-row mb-5 pb-4 flex-row-reverse"> {{-- Reversed row --}}
			<div class="col-lg-5 text-center text-lg-end mb-4 mb-lg-0"> {{-- Text end --}}
				<div class="step-content">
					<div class="step-number-funky ms-lg-auto">{{ __('default.how_it_works.step2.number') }}</div> {{-- Margin start auto --}}
					<h4 class="inria-serif-regular mb-3">{{ __('default.how_it_works.step2.heading') }}</h4>
					<p class="step-description inria-serif-regular">{{ __('default.how_it_works.step2.description') }}</p>
				</div>
			</div>
			<div class="col-lg-6 offset-lg-1 d-flex justify-content-center">
				<div class="book-covers-grid text-center">
					<img src="/images/book1.jpg" alt="Book Cover" class="img-fluid book-cover-image shadow" style="transform: rotate(-5deg);">
					<img src="/images/book2.jpg" alt="Book Cover" class="img-fluid book-cover-image shadow" style="transform: rotate(3deg);">
					<br>
					<img src="/images/book3.jpg" alt="Book Cover" class="img-fluid book-cover-image shadow" style="transform: rotate(4deg);">
					<img src="/images/book4.jpg" alt="Book Cover" class="img-fluid book-cover-image shadow" style="transform: rotate(-2deg);">
				</div>
			</div>
			{{-- Connecting Line/Arrow (Example) --}}
			<div class="step-connector step-connector-down"></div>
		</div>
		
		{{-- Step 3 --}}
		<div class="row align-items-center step-row mb-5">
			<div class="col-lg-5 text-center text-lg-start mb-4 mb-lg-0">
				<div class="step-content">
					<div class="step-number-funky">{{ __('default.how_it_works.step3.number') }}</div>
					<h4 class="inria-serif-regular mb-3">{{ __('default.how_it_works.step3.heading') }}</h4>
					<p class="step-description inria-serif-regular">{{ __('default.how_it_works.step3.description') }}</p>
				</div>
			</div>
			<div class="col-lg-6 offset-lg-1 text-center">
				<div class="book-preview">
					<img src="/images/open-book.webp" alt="Open Book" class="img-fluid rounded shadow-lg" style="transform: scale(1.05) rotate(1deg);"> {{-- Slightly larger and tilted --}}
				</div>
			</div>
			{{-- No connector after last step --}}
		</div>
	</div>
</section>

<style>
    .how-it-works {
        background-color: #ffffff; /* White background */
    }

    .step-row {
        position: relative; /* Needed for connector positioning */
    }

    .step-number-funky {
        background-color: var(--bs-primary);
        color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: inline-flex; /* Use inline-flex */
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
        box-shadow: 0 4px 8px rgba(var(--bs-primary-rgb), 0.4);
    }

    .step-content h4 {
        font-weight: 600;
    }

    .step-description {
        color: #6c757d; /* Softer text color */
        font-size: 1rem;
        line-height: 1.6;
    }

    .question-card-funky {
        background-color: #fff1e6; /* Keep original color */
        border-radius: 15px;
        padding: 20px;
        color: #1c1c1c !important;
        max-width: 350px; /* Slightly wider */
        transform: rotate(-2deg); /* Tilt the card */
        transition: transform 0.3s ease;
    }
    .question-card-funky:hover {
        transform: rotate(0deg); /* Straighten on hover */
    }

    .profile-header { text-align: center; margin-bottom: 15px; }
    .profile-img img { width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid white; }
    .question-item { background-color: #ffffff; border-radius: 8px; padding: 0.75rem; margin-bottom: 0.75rem; }
    .question-item-shadow { box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
    .answer-text { border: none; /* Remove border */ }

    .book-cover-image {
        max-width: 110px; /* Slightly smaller */
        margin: 5px; /* Add spacing */
        border-radius: 5px;
        transition: transform 0.3s ease;
    }
    .book-cover-image:hover {
        transform: scale(1.1) rotate(0deg) !important; /* Enlarge and straighten on hover */
        z-index: 10;
        position: relative;
    }

    .book-preview img {
        max-width: 320px;
        transition: transform 0.3s ease;
    }
    .book-preview img:hover {
        transform: scale(1.1) rotate(0deg) !important; /* Enlarge and straighten */
    }

    /* Connector styles */
    .step-connector {
        position: absolute;
        bottom: 0; /* Position at the bottom of the row */
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 40px; /* Height of the line */
        background-color: rgba(var(--bs-primary-rgb), 0.3); /* Lighter primary color */
        display: none; /* Hide by default */
    }

    /* Show connectors on larger screens */
    @media (min-width: 992px) {
        .step-connector {
            display: block;
        }
        /* Adjust connector position if needed based on layout */
        .step-row:nth-child(odd) .step-connector { /* Step 1, 3 */
            /* left: 50%; */ /* Default is fine */
        }
        .step-row:nth-child(even) .step-connector { /* Step 2 */
            /* left: 50%; */ /* Default is fine */
        }
    }


    @media (max-width: 991.98px) {
        .step-number-funky { margin-left: auto; margin-right: auto; display: flex; } /* Center number */
        .step-content { text-align: center; }
        .question-card-funky { transform: rotate(0deg); max-width: 90%; } /* Straighten card */
        .book-cover-image { transform: rotate(0deg) !important; } /* Straighten covers */
        .book-preview img { transform: scale(1) rotate(0deg) !important; } /* Straighten preview */
        .step-row { margin-bottom: 3rem; padding-bottom: 0; } /* Adjust spacing */
    }
</style>
