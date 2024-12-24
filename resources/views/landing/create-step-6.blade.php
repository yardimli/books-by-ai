<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<div class="step-6-book-container" href="#">
			<div class="step-6-book">
				<img src="{{ $book->book_cover_image }}" id="previewFrontCover"/>
			</div>
		</div>
		
		<div class="text-center mt-4">
			@php
				$bookOptions = json_decode($book->book_options, true);
				$selectedOption = $bookOptions[$book->selected_book_option] ?? null;
			@endphp
			<div class="fw-bold fs-5 book-title">{{ $selectedOption['title'] ?? '' }}</div>
			<div class="book-subtitle" style="display: none;">{{ $selectedOption['subtitle'] ?? '' }}</div>
			<div class="book-author-name">{{ $book->author_name }}</div>
		</div>
		
		<div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
			<div id="regenerateBtn" class="btn btn-dark mt-3 mt-md-0"> <!-- Added margin-top for spacing on mobile -->
				<i class="bi bi-arrow-clockwise"></i> {{ __('default.create.buttons.regenerate') }}
			</div>
		</div>
		
		<div id="loadingSpinner" class="text-center my-5 d-none">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">{{ __('default.create.step6.loading') }}</span>
			</div>
		</div>
		
		<!-- Book TOC container -->
		<div id="bookTOC">
			<!-- Book TOC will be inserted here -->
		</div>
		
		<div class="fixed-bottom-bar">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8">
						<div class="d-grid">
							<button class="btn btn-lg text-white" style="background-color: #dc6832;" id="continueBtn">
								{{ __('default.create.buttons.continue') }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
    .step-6-book-container {
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 600px;
        margin-top: 40px;
        margin-bottom: 60px;
    }

    @keyframes step-6-initAnimation {
        0% {
            transform: rotateY(0deg);
        }
        100% {
            transform: rotateY(-30deg);
        }
    }

    .step-6-book {
        width: 200px;
        height: 300px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-30deg);
        transition: 1s ease;
        animation: 1s ease 0s 1 initAnimation;
    }

    .step-6-book:hover {
        transform: rotateY(0deg);
    }

    .step-6-book > :first-child {
        position: absolute;
        top: 0;
        left: 0;
        background-color: red;
        width: 200px;
        height: 300px;
        transform: translateZ(25px);
        background-color: #01060f;
        border-radius: 0 2px 2px 0;
        box-shadow: 5px 5px 20px #666;
    }

    .step-6-book::before {
        position: absolute;
        content: ' ';
        background-color: blue;
        left: 0;
        top: 3px;
        width: 48px;
        height: 294px;
        transform: translateX(172px) rotateY(90deg);
        background: linear-gradient(90deg,
        #fff 0%,
        #f9f9f9 5%,
        #fff 10%,
        #f9f9f9 15%,
        #fff 20%,
        #f9f9f9 25%,
        #fff 30%,
        #f9f9f9 35%,
        #fff 40%,
        #f9f9f9 45%,
        #fff 50%,
        #f9f9f9 55%,
        #fff 60%,
        #f9f9f9 65%,
        #fff 70%,
        #f9f9f9 75%,
        #fff 80%,
        #f9f9f9 85%,
        #fff 90%,
        #f9f9f9 95%,
        #fff 100%
        );
    }

    .step-6-book::after {
        position: absolute;
        top: 0;
        left: 0;
        content: ' ';
        width: 200px;
        height: 300px;
        transform: translateZ(-25px);
        background-color: #888;
        border-radius: 0 2px 2px 0;
        box-shadow: -10px 0 50px 10px #666;
    }


    .fixed-bottom-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        z-index: 1000;
        background-color: #ffffff;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    [data-bs-theme=dark] .fixed-bottom-bar {
        background-color: #212529;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Add these to your existing styles */
    .act-title {
        color: #111;
        margin-top: 2rem;
        padding-bottom: 0.5rem;
    }

    .chapter-container {
        margin-left: 1.5rem;
        padding-left: 1rem;
    }

    .chapter-title-color {
        color: #222;
    }

    .chapter-description-color {
        color: #555;
    }

    [data-bs-theme=dark] .act-title {
				color: #ddd;
		}
    
    [data-bs-theme=dark] .chapter-title-color {
				color: #ddd;
		}
    
    [data-bs-theme=dark] .chapter-description-color {
        color: #ccc;
    }
    


</style>

@push('scripts')
	<script>
		function renderBookTOC(bookTOC) {
			if (bookTOC && bookTOC.acts && bookTOC.acts.length > 0) {
				$('#bookTOC').html('<div class="fs-4 mb-4 inria-serif-bold chapter-title-color">İçindekiler</div>');
				
				bookTOC.acts.forEach((act, actIndex) => {
					// Add act name
					const actHtml = `
                <div class="fs-4 inria-serif-bold act-title mb-3">${act.name}</div>
            `;
					$('#bookTOC').append(actHtml);
					
					// Add chapters under this act
					if (act.chapters && act.chapters.length > 0) {
						act.chapters.forEach((chapter, chapterIndex) => {
							const chapterHtml = `
                        <div class="ms-4 mb-4">
                            <div class="fs-5 inria-serif-bold chapter-title-color">
                                ${chapter.chapter_number}. ${chapter.chapter_title}
                            </div>
                            <div class="fs-6 inria-serif-regular chapter-description-color">
                                ${chapter.chapter_short_description}
                            </div>
                        </div>
                    `;
							$('#bookTOC').append(chapterHtml);
						});
					}
				});
				
				$('#continueBtn').prop('disabled', false);
			}
		}
		
		function createBookTOC() {
			$('#loadingSpinner').removeClass('d-none');
			$('#bookTOC').empty();
			$('#regenerateBtn').hide();
			$('#continueBtn').prop('disabled', true);
			
			$.ajax({
				url: "{{ route('create-book-toc') }}",
				method: 'POST',
				dataType: 'json',
				data: {
					book_guid: '{{ $book->book_guid }}',
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					$('#loadingSpinner').addClass('d-none');
					$('#regenerateBtn').show();
					
					try {
						if (response.acts) {
							// Save TOC to database
							saveTOCToDatabase(response);
							renderBookTOC(response);
						} else {
							console.error('TOC not found in the response');
							$('#bookTOC').html('<div class="alert alert-danger">{{ __("default.create.step6.error.loading_error") }}</div>');
						}
					} catch (e) {
						console.error('Error parsing TOC:', e);
						$('#bookTOC').html('<div class="alert alert-danger">{{ __("default.create.step6.error.loading_error") }}</div>');
					}
				},
				error: function() {
					$('#regenerateBtn').show();
					$('#loadingSpinner').addClass('d-none');
					$('#bookTOC').html('<div class="alert alert-danger">{{ __("default.create.step6.error.loading_error") }}</div>');
				}
			});
		}
		
		function saveTOCToDatabase(toc) {
			$.ajax({
				url: '{{ route("update-book") }}',
				method: 'POST',
				data: {
					_token: '{{ csrf_token() }}',
					book_guid: '{{ $book->book_guid }}',
					step: 6,
					toc: toc
				},
				success: function(response) {
					if (!response.success) {
						console.error('Failed to save TOC to database');
					}
				}
			});
		}
		
		$(document).ready(function() {
			$('#continueBtn').prop('disabled', true);
			
			// Load existing TOC from database
			const existingTOC =  {!! $book->book_toc ?? 'null' !!};
			console.log( existingTOC);
			if (existingTOC && existingTOC.acts && existingTOC.acts.length > 0) {
				renderBookTOC(existingTOC);
			} else {
				createBookTOC();
			}
			
			$('#regenerateBtn').click(function() {
				createBookTOC();
			});
			
			$('#continueBtn').click(function() {
				window.location.href = '{{ route("create-book") }}?adim=7&kitap_kodu={{ $book->book_guid }}';
			});
		});
	</script>
@endpush
