<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<div class="d-flex justify-content-center align-items-center gap-0">
			<!-- Left div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm" id="front-cover">
				@include('landing.cover1')
			</div>
			<!-- Middle div -->
			<div style="width: 34px; height: 480px;" class="bg-light shadow-sm mx-2" id="spine-cover">
				@include('landing.spine1')
			</div>
			<!-- Right div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm" id="back-cover">
				@include('landing.back1')
			</div>
		</div>
		
		<!-- Cover Style Selector -->
		<div class="d-flex justify-content-center gap-2 mt-4 mb-4">
			@for ($i = 1; $i <= 6; $i++)
				<button class="cover-style-btn rounded-circle d-flex align-items-center justify-content-center"
				        data-style="{{ $i }}"
				        style="width: 40px; height: 40px; border: 2px solid #dc6832; background-color: {{ $i === 1 ? '#dc6832' : 'transparent' }}; color: {{ $i === 1 ? 'white' : '#dc6832' }};">
					{{ $i }}
				</button>
			@endfor
		</div>
		
		<div class="mt-4 mb-3 text-center">
			<div type="button" class="btn btn-primary d-inline-block" data-bs-toggle="modal" data-bs-target="#imageAdjustModal">
				{{ __('default.create.buttons.adjust_image') }}
			</div>
		</div>
		
		<div class="d-grid mt-4">
			<div class="btn btn-lg text-white" style="background-color: #dc6832;" onclick="nextStep()">
				{{ __('default.create.buttons.continue') }}
			</div>
		</div>
	</div>
</div>

<!-- Add the modal HTML -->
<div class="modal fade" id="imageAdjustModal" tabindex="-1" aria-labelledby="imageAdjustModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="imageAdjustModalLabel">Adjust Author Image</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="image-container" style="width: 150px; height: 200px; margin: 0 auto; overflow: hidden; position: relative;">
					<img id="adjustableImage" src="" style="position: absolute; cursor: move;">
				</div>
				<div class="mt-3">
					<label for="zoomRange" class="form-label">Zoom Level</label>
					<input type="range" class="form-range" id="zoomRange" min="100" max="200" value="100">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="saveImageAdjustments">Save Changes</button>
			</div>
		</div>
	</div>
</div>

<style>
    #adjustableImage {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform-origin: center;
        user-select: none;
        -webkit-user-drag: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .image-container {
        background-color: #f8f9fa;
        border: 2px solid #dee2e6;
    }

    [data-bs-theme=dark] .image-container {
        background-color: #343a40;
        border-color: #495057;
    }

    .form-range::-webkit-slider-thumb {
        background: #dc6832;
    }

    .form-range::-moz-range-thumb {
        background: #dc6832;
    }
</style>

@push('scripts')
	<script>
		
		const bookData = {
			title: "Reality Gone Rouge!",
			subtitle: "Chronicles of Mischief with Mick and Lara in the Home-Buying World",
			authorName: "Lala Lulu"
		};
		
		const ZOOM_SPEED = 0.1;
		const MIN_SCALE = 1;
		const MAX_SCALE = 2;
		let isDragging = false;
		let currentX;
		let currentY;
		let initialX;
		let initialY;
		let xOffset = 0;
		let yOffset = 0;
		let scale = 1;
		
		
		let authorImage = "/storage/author-images/large/" + localStorage.getItem('characterImageNoBg');
		
		function applyCoverTextFields(cover_part) {
			if (cover_part === 'front') {
				$('.title').text(bookData.title);
				
				$('.subtitle').text(bookData.subtitle);
				$('.author-name').text(bookData.authorName);
				$('.author-image').attr('src', authorImage);
			}
			
			if (cover_part === 'spine') {
				$('.book-spine-title').text(bookData.title);
				$('.book-spine-author-name').text(bookData.authorName);
			}
			
			if (cover_part === 'back') {
				$('.backcover-main-title').text('Praises for ' + bookData.title);
				$('.review-text-1').text('“In \'' + bookData.title + '\', LaLa La perfectly captures the insanity and hilarity of the real estate realm. Mick and Lara\'s antics will have readers laughing out loud from page one. A must-read for anyone looking for a humorous escape from the everyday grind.”');
				$('.review-source-1').text('—Bookish Buzz');
			}
			
			// Wait for a brief moment to ensure content is rendered
			setTimeout(() => {
				$('.uppercase-title').each(function() {
					let text = $(this).text();
					let formatted = text.replace(/\b(\w)(\w*)\b/g, function(match, firstLetter, rest) {
						return `<span class="uppercase-title-first-letter">${firstLetter}</span>${rest}`;
					});
					$(this).html(formatted);
				});
				
				$('.uppercase-author-name').each(function() {
					let text = $(this).text();
					let formatted = text.replace(/\b(\w)(\w*)\b/g, function(match, firstLetter, rest) {
						return `<span class="uppercase-author-name-first-letter">${firstLetter}</span>${rest}`;
					});
					$(this).html(formatted);
				});
				
				$('.upper-case-back-main-title').each(function() {
					let text = $(this).text();
					let formatted = text.replace(/\b(\w)(\w*)\b/g, function(match, firstLetter, rest) {
						return `<span class="upper-case-back-main-title-first-letter">${firstLetter}</span>${rest}`;
					});
					$(this).html(formatted);
				});
			}, 100);
		}
		
		function dragStart(e) {
			if (e.type === "touchstart") {
				initialX = e.touches[0].clientX - xOffset;
				initialY = e.touches[0].clientY - yOffset;
			} else {
				initialX = e.clientX - xOffset;
				initialY = e.clientY - yOffset;
			}
			
			if (e.target === $('#adjustableImage')[0]) {
				isDragging = true;
			}
		}
		
		function drag(e) {
			if (isDragging) {
				e.preventDefault();
				
				if (e.type === "touchmove") {
					currentX = e.touches[0].clientX - initialX;
					currentY = e.touches[0].clientY - initialY;
				} else {
					currentX = e.clientX - initialX;
					currentY = e.clientY - initialY;
				}
				
				xOffset = currentX;
				yOffset = currentY;
				
				setTransform();
			}
		}
		
		function dragEnd() {
			isDragging = false;
		}
		
		function setTransform() {
			// Ensure scale stays within bounds
			scale = Math.max(MIN_SCALE, Math.min(MAX_SCALE, scale));
			
			$('#adjustableImage').css('transform',
				`translate(${xOffset}px, ${yOffset}px) scale(${scale})`);
		}
		
		$(document).ready(function () {
			// Add wheel event listener to the image container
			$('.image-container').on('wheel', function(e) {
				e.preventDefault();
				
				// Determine zoom direction
				const delta = e.originalEvent.deltaY;
				if (delta > 0) {
					// Zoom out
					scale = Math.max(MIN_SCALE, scale - ZOOM_SPEED);
				} else {
					// Zoom in
					scale = Math.min(MAX_SCALE, scale + ZOOM_SPEED);
				}
				
				// Update the range slider value
				$('#zoomRange').val(scale * 100);
				
				// Apply the transformation
				setTransform();
			});
			
			// Initialize the adjustable image when modal opens
			$('#imageAdjustModal').on('show.bs.modal', function() {
				const authorImage = $('.author-image').attr('src');
				$('#adjustableImage').attr('src', authorImage);
				
				// Reset position and scale
				xOffset = 0;
				yOffset = 0;
				scale = 1;
				$('#zoomRange').val(100);
				setTransform();
			});
			
			// Mouse events for drag
			$('#adjustableImage').on('mousedown', dragStart);
			$(document).on('mousemove', drag);
			$(document).on('mouseup', dragEnd);
			
			// Touch events for mobile
			$('#adjustableImage').on('touchstart', dragStart);
			$(document).on('touchmove', drag);
			$(document).on('touchend', dragEnd);
			
			// Zoom slider
			$('#zoomRange').on('input', function() {
				scale = $(this).val() / 100;
				setTransform();
			});
			
			// Save adjustments
			$('#saveImageAdjustments').on('click', function() {
				const adjustedImage = $('#adjustableImage');
				const transform = adjustedImage.css('transform');
				
				// Apply the same transformation to the main author image
				$('.author-image').css('transform', transform);
				
				// Close the modal
				$('#imageAdjustModal').modal('hide');
			});
			
			
			$('.cover-style-btn').on('click', function() {
				const styleNumber = $(this).data('style');
				
				// Update button styles
				$('.cover-style-btn').css({
					'background-color': 'transparent',
					'color': '#dc6832'
				});
				$(this).css({
					'background-color': '#dc6832',
					'color': 'white'
				});
				
				// Load front cover
				$.get(`{{ route('load-cover') }}/${styleNumber}`, function(response) {
					$('#front-cover').html(response);
					applyCoverTextFields('front');
				});
				
				// Load spine
				$.get(`{{ route('load-spine') }}/${styleNumber}`, function(response) {
					$('#spine-cover').html(response);
					applyCoverTextFields('spine');
				});
				
				// Load back cover
				$.get(`{{ route('load-back') }}/${styleNumber}`, function(response) {
					$('#back-cover').html(response);
					applyCoverTextFields('back');
				});
				
				// Save selected style to localStorage
				localStorage.setItem('selectedCoverStyle', styleNumber);
			});
			
			// Load saved style on page load
			const savedStyle = localStorage.getItem('selectedCoverStyle');
			if (savedStyle) {
				$(`.cover-style-btn[data-style="${savedStyle}"]`).click();
			}
		});
	</script>
	
	<style>
      .cover-style-btn {
          transition: all 0.3s ease;
          cursor: pointer;
          border: 2px solid #dc6832;
          outline: none;
      }

      .cover-style-btn:hover {
          transform: scale(1.1);
      }

      [data-bs-theme=dark] .cover-style-btn {
          border-color: #dc6832;
      }
	</style>
@endpush
