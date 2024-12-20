<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
					      stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<div class="d-flex justify-content-center align-items-center gap-0">
			<!-- Left div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm" id="front-cover">
				@include('landing.cover1')
			</div>
			<!-- Middle div -->
			<div style="width: 24px; height: 480px;" class="bg-light shadow-sm mx-2" id="spine-cover">
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
			<div type="button" class="btn btn-primary d-inline-block" data-bs-toggle="modal"
			     data-bs-target="#imageAdjustModal">
				{{ __('default.create.buttons.adjust_image') }}
			</div>
		</div>
		
		<div class="d-grid mt-4">
			<div class="btn btn-lg text-white continueBtn" style="background-color: #dc6832;" onclick="nextStep()">
				{{ __('default.create.buttons.continue') }}
			</div>
		</div>
	</div>
</div>

<!-- Update the modal HTML -->
<div class="modal fade" id="imageAdjustModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ __('default.create.modals.adjust_image') }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body">
				<div class="modal-image-container">
					<img id="adjustableImage" src="">
				</div>
				<div class="mt-3">
					<label for="zoomRange" class="form-label">{{ __('default.create.modals.zoom_level') }}</label>
					<input type="range" class="form-range" id="zoomRange" min="25" max="300" value="100">
				</div>
			</div>
			<div class="modal-footer">
				<!-- Add reset button -->
				<button type="button" class="btn btn-outline-secondary" id="resetImageAdjustments">
					<i class="fas fa-undo"></i> {{ __('default.create.buttons.reset') }}
				</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('default.create.buttons.cancel') }}</button>
				<button type="button" class="btn btn-primary" id="saveImageAdjustments">{{ __('default.create.buttons.save_changes') }}</button>
			</div>
		</div>
	</div>
</div>

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
    
    .modal-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 50%; /* Match the circular shape */
        text-align: center;
        width: 160px;
        height: 220px;
        margin: 0 auto; /* Center the container horizontally */
    }

    #adjustableImage {
        position: absolute;
		    width: 100%;
        user-select: none;
        -webkit-user-drag: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .form-range::-webkit-slider-thumb {
        background: #dc6832;
    }

    .form-range::-moz-range-thumb {
        background: #dc6832;
    }

    #resetImageAdjustments {
        color: #6c757d;
        border-color: #6c757d;
        transition: all 0.2s ease;
    }

    #resetImageAdjustments:hover {
        background-color: #6c757d;
        color: white;
    }

    [data-bs-theme=dark] #resetImageAdjustments {
        color: #adb5bd;
        border-color: #adb5bd;
    }

    [data-bs-theme=dark] #resetImageAdjustments:hover {
        background-color: #adb5bd;
        color: #343a40;
    }
</style>

@push('scripts')
	<script>
		const ZOOM_SPEED = 0.1;
		const MIN_SCALE = 0.25;
		const MAX_SCALE = 3;
		let isDragging = false;
		let currentX;
		let currentY;
		let initialX;
		let initialY;
		let xOffset = 0;
		let yOffset = 0;
		let scale = 1;
		
		let transformSettings = JSON.parse(localStorage.getItem('authorImageTransform')) || {
			xOffset: 0,
			yOffset: 0,
			scale: 1
		};
		
		let authorImage = localStorage.getItem('authorImageNoBg');
		
		function captureCovers() {
			return new Promise(async (resolve, reject) => {
				try {
					// Wait for all elements to be fully rendered
					await new Promise(resolve => setTimeout(resolve, 500));
					
					// Capture front cover
					const frontCover = await html2canvas(document.querySelector('#front-cover'), {
						scale: 2,
						useCORS: true,
						allowTaint: true,
						backgroundColor: null,
						logging: false
					});
					const frontCoverImage = frontCover.toDataURL('image/png');
					localStorage.setItem('frontCoverImage', frontCoverImage);
					
					// Capture spine
					const spineCover = await html2canvas(document.querySelector('#spine-cover'), {
						scale: 2,
						useCORS: true,
						allowTaint: true,
						backgroundColor: null,
						logging: false
					});
					const spineCoverImage = spineCover.toDataURL('image/png');
					localStorage.setItem('spineCoverImage', spineCoverImage);
					
					// Capture back cover
					const backCover = await html2canvas(document.querySelector('#back-cover'), {
						scale: 2,
						useCORS: true,
						allowTaint: true,
						backgroundColor: null,
						logging: false
					});
					const backCoverImage = backCover.toDataURL('image/png');
					localStorage.setItem('backCoverImage', backCoverImage);
					
					resolve(true);
				} catch (error) {
					console.error('Error capturing covers:', error);
					reject(error);
				}
			});
		}
		
		function updateCoverImages() {
			authorImage = localStorage.getItem('authorImageNoBg');
			if (authorImage) {
				$('.author-image').attr('src', authorImage);
				
				// Also update the adjustable image if the modal is open
				$('#adjustableImage').attr('src', authorImage);
				
				// Apply any stored transform settings
				transformSettings = JSON.parse(localStorage.getItem('authorImageTransform'));
				if (transformSettings) {
					const transformValue = `translate(${transformSettings.xOffset}px, ${transformSettings.yOffset}px) scale(${transformSettings.scale})`;
					$('.author-image').css('transform', transformValue);
				}
				
				// Reload the current cover style
				const currentStyle = localStorage.getItem('selectedCoverStyle') || 1;
				$(`.cover-style-btn[data-style="${currentStyle}"]`).click();
			}
		}
		
		function getCoverStyleProperties(styleNumber) {
			const styles = {
				1: {
					shape: 'circle',
					width: '160px',
					height: '220px',
					backgroundColor: '#ead0b3'
				},
				2: {
					shape: 'rectangle',
					width: '320px',
					height: '235px',
					backgroundColor: '#0c0c0c'
				},
				3: {
					shape: 'rectangle',
					width: '320px',
					height: '480px',
					backgroundColor: '#bababa'
				},
				4: {
					shape: 'rectangle',
					width: '320px',
					height: '200px',
					backgroundColor: '#000000'
				},
				5: {
					shape: 'circle',
					width: '160px',
					height: '180px',
					backgroundColor: '#f1f1f1'
				},
				6: {
					shape: 'rectangle',
					width: '210px',
					height: '210px',
					backgroundColor: '#f1f1f1'
				}
			};
			return styles[styleNumber] || styles[1];
		}
		
		function applyCoverTextFields(cover_part) {
			if (cover_part === 'front') {
				$('.title').text((bookData.title ?? 'Başlık'));
				
				$('.subtitle').text(bookData.subtitle ?? 'Alt Başlık');
				$('.author-name').text(localStorage.getItem('authorName') ?? 'Yazar Adı');
				$('.author-image').attr('src', authorImage);
			}
			
			if (cover_part === 'spine') {
				$('.book-spine-title').text(bookData.title ?? 'Başlık');
				$('.book-spine-author-name').text(localStorage.getItem('authorName') ?? 'Yazar Adı');
			}
			
			if (cover_part === 'back') {
				$('.backcover-main-title').text(bookData.title+ ' için Övgüler');
				$('.review-text-1').text(bookData.short_review_1 ?? 'Yorum 1');
				$('.review-source-1').text(bookData.short_review_1_source ?? 'Kaynak 1');
				
				$('.review-text-2').text(bookData.short_review_2 ?? 'Yorum 2');
				$('.review-source-2').text(bookData.short_review_2_source ?? 'Kaynak 2');
				
				$('.review-text-3').text(bookData.short_review_3 ?? 'Yorum 3');
				$('.review-source-3').text(bookData.short_review_3_source ?? 'Kaynak 3');
				
				$('.review-text-4').text(bookData.short_review_4 ?? 'Yorum 4');
				$('.review-source-4').text(bookData.short_review_4_source ?? 'Kaynak 4');
			}
			
			// Wait for a brief moment to ensure content is rendered
			setTimeout(() => {
				$('.uppercase-title').each(function () {
					let text = $(this).text();
					let formatted = text.replace(/(?:^|\s)([\p{L}\p{N}])([\p{L}\p{N}]*)/gu, function (match, firstLetter, rest) {
						return ` <span class="uppercase-title-first-letter">${firstLetter}</span>${rest}`;
					}).trim();
					$(this).html(formatted);
				});
				
				$('.uppercase-author-name').each(function () {
					let text = $(this).text();
					let formatted = text.replace(/(?:^|\s)([\p{L}\p{N}])([\p{L}\p{N}]*)/gu, function (match, firstLetter, rest) {
						return ` <span class="uppercase-author-name-first-letter">${firstLetter}</span>${rest}`;
					}).trim();
					$(this).html(formatted);
				});
				
				$('.uppercase-spine-title').each(function () {
					let text = $(this).text();
					let formatted = text.replace(/(?:^|\s)([\p{L}\p{N}])([\p{L}\p{N}]*)/gu, function (match, firstLetter, rest) {
						return ` <span class="uppercase-spine-title-first-letter">${firstLetter}</span>${rest}`;
					}).trim();
					$(this).html(formatted);
				});
				
				$('.uppercase-back-main-title').each(function () {
					let text = $(this).text();
					let formatted = text.replace(/(?:^|\s)([\p{L}\p{N}])([\p{L}\p{N}]*)/gu, function (match, firstLetter, rest) {
						return ` <span class="uppercase-back-main-title-first-letter">${firstLetter}</span>${rest}`;
					}).trim();
					$(this).html(formatted);
				});
			}, 100);
			
			// Apply stored transform settings to the author image
			if (transformSettings) {
				const transformValue = `translate(${transformSettings.xOffset}px, ${transformSettings.yOffset}px) scale(${transformSettings.scale})`;
				$('.author-image').css('transform', transformValue);
			}
		}
		
		function dragStart(e) {
			if (e.type === "touchstart") {
				initialX = e.touches[0].clientX - (parseFloat($('#adjustableImage').css('left')) || 0);
				initialY = e.touches[0].clientY - (parseFloat($('#adjustableImage').css('top')) || 0);
			} else {
				initialX = e.clientX - (parseFloat($('#adjustableImage').css('left')) || 0);
				initialY = e.clientY - (parseFloat($('#adjustableImage').css('top')) || 0);
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
			
			// Store the current settings
			transformSettings = {
				xOffset: xOffset,
				yOffset: yOffset,
				scale: scale
			};
			
			// Save to localStorage
			localStorage.setItem('authorImageTransform', JSON.stringify(transformSettings));
			
			// Apply to adjustable image
			$('#adjustableImage').css({
				'left': `${xOffset}px`,
				'top': `${yOffset}px`,
				'transform': `scale(${scale})`
			});
		}
		
		// Load saved transform settings and apply them
		function applyStoredTransformSettings() {
			if (transformSettings) {
				xOffset = transformSettings.xOffset;
				yOffset = transformSettings.yOffset;
				scale = transformSettings.scale;
				
				$('.author-image').css({
					'left': `${xOffset}px`,
					'top': `${yOffset}px`,
					'transform': `scale(${scale})`
				});
				
				// Update zoom slider
				$('#zoomRange').val(scale * 100);
			}
		}
		
		function updateModalImageContainer(styleNumber) {
			const props = getCoverStyleProperties(styleNumber);
			const container = $('.modal-image-container');
			
			container.css({
				width: props.width,
				height: props.height,
				backgroundColor: props.backgroundColor,
				borderRadius: props.shape === 'circle' ? '50%' : '0px',
				margin: '0 auto'
			});
			
			// Update the adjustable image styles
			// $('#adjustableImage').css({
			// 	height: props.height,
			// 	width: props.shape === 'circle' ? 'auto' : '100%',
			// 	objectFit: 'cover'
			// });
		}
		
		function resetTransform() {
			xOffset = 0;
			yOffset = 0;
			scale = 1;
			
			$('#zoomRange').val(100);
			
			$('#adjustableImage').css({
				'left': '0px',
				'top': '0px',
				'transform': 'scale(1)'
			});
		}
		
		$(document).ready(function () {
			bookData = JSON.parse(localStorage.getItem('selectedSuggestion'));
			// Apply stored settings on page load
			applyStoredTransformSettings();
			
			$('#resetImageAdjustments').on('click', function() {
				resetTransform();
			});
			
			// Add wheel event listener to the image container
			$('.modal-image-container').on('wheel', function (e) {
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
			$('#imageAdjustModal').on('show.bs.modal', function () {
				const authorImage = $('.author-image').attr('src');
				const currentStyle = localStorage.getItem('selectedCoverStyle') || 1;
				
				$('#adjustableImage').attr('src', authorImage);
				updateModalImageContainer(currentStyle);
				
				// Load saved transform settings
				if (transformSettings) {
					xOffset = transformSettings.xOffset;
					yOffset = transformSettings.yOffset;
					scale = transformSettings.scale;
					$('#zoomRange').val(scale * 100);
					setTransform();
				}
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
			$('#zoomRange').on('input', function () {
				scale = $(this).val() / 100;
				setTransform();
			});
			
			// Save adjustments
			$('#saveImageAdjustments').on('click', function () {
				$('.author-image').css({
					'left': `${xOffset}px`,
					'top': `${yOffset}px`,
					'transform': `scale(${scale})`
				});
				
				transformSettings = {
					xOffset: xOffset,
					yOffset: yOffset,
					scale: scale
				};
				
				localStorage.setItem('authorImageTransform', JSON.stringify(transformSettings));
				
				$('#imageAdjustModal').modal('hide');
			});
			
			
			
			$('.cover-style-btn').on('click', function () {
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
				
				updateModalImageContainer(styleNumber);
				
				// Load front cover
				$.get(`{{ route('load-cover') }}/${styleNumber}`, function (response) {
					$('#front-cover').html(response);
					applyCoverTextFields('front');
				});
				
				// Load spine
				$.get(`{{ route('load-spine') }}/${styleNumber}`, function (response) {
					$('#spine-cover').html(response);
					applyCoverTextFields('spine');
				});
				
				// Load back cover
				$.get(`{{ route('load-back') }}/${styleNumber}`, function (response) {
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
@endpush
