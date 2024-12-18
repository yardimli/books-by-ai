<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<h4 class="mb-4">Upload a photo of your character</h4>
		<p class="text-muted mb-4">We'll use it on the cover</p>
		
		<div class="upload-container text-center">
			<div id="imagePreviewContainer" class="mb-4 d-none">
				<img id="imagePreview" class="img-fluid rounded" style="max-height: 300px;" alt="Preview">
				<br>
				<button type="button" class="btn btn-link text-danger mt-2" id="removeImage">Remove Image</button>
			</div>
			
			<div id="uploadControls">
				<label for="imageUpload" class="btn btn-primary mb-3">
					Choose Image
					<input type="file" id="imageUpload" class="d-none" accept="image/*">
				</label>
				<div id="uploadSpinner" class="d-none">
					<div class="spinner-border text-primary" role="status">
						<span class="visually-hidden">Loading...</span>
					</div>
					<p class="mt-2">Processing image...</p>
				</div>
			</div>
		</div>
		
		<div class="d-grid mt-4">
			<button class="btn btn-lg text-white" id="continueBtn" style="background-color: #dc6832;" onclick="nextStep()" disabled>
				{{ __('default.create.buttons.continue') }}
			</button>
		</div>
	</div>
</div>

@push('scripts')
	<script>
		$(document).ready(function () {
			const imageUpload = $('#imageUpload');
			const imagePreview = $('#imagePreview');
			const imagePreviewContainer = $('#imagePreviewContainer');
			const uploadSpinner = $('#uploadSpinner');
			const continueBtn = $('#continueBtn');
			const removeImageBtn = $('#removeImage');
			
			// Check if we have a saved image
			const savedImage = localStorage.getItem('characterImage');
			const savedImageNoBg = localStorage.getItem('characterImageNoBg');
			
			if (savedImage) {
				imagePreview.attr('src', savedImage);
				imagePreviewContainer.removeClass('d-none');
				continueBtn.prop('disabled', false);
			}
			
			imageUpload.on('change', function(e) {
				const file = e.target.files[0];
				if (!file) return;
				
				// Show preview immediately
				const reader = new FileReader();
				reader.onload = function(e) {
					imagePreview.attr('src', e.target.result);
					imagePreviewContainer.removeClass('d-none');
				}
				reader.readAsDataURL(file);
				
				// Prepare for upload
				const formData = new FormData();
				formData.append('image', file);
				formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
				
				
				// Show spinner
				uploadSpinner.removeClass('d-none');
				continueBtn.prop('disabled', true);
				
				// Upload to temporary storage and get URL
				$.ajax({
					url: '{{route('upload-author-image')}}',
					method: 'POST',
					processData: false,
					contentType: false,
					data: formData,
					success: function(response) {
						let authorOriginalImage = response.url;
						// Now call removeBg with the temporary URL
						$.ajax({
							url: '{{ route("remove-bg") }}',
							method: 'POST',
							data: {
								image_url: 'https://kitabimzade.com/storage/author-images/author.jpg', // authorOriginalImage,
								_token: $('meta[name="csrf-token"]').attr('content')
							},
							success: function(response) {
								const result = JSON.parse(response);
								if (result.success) {
									// Save both versions to localStorage
									localStorage.setItem('characterImage', authorOriginalImage);
									localStorage.setItem('characterImageNoBg', result.image_large_filename);
									continueBtn.prop('disabled', false);
								} else {
									alert('Error processing image. Please try again.');
								}
							},
							error: function() {
								alert('Error processing image. Please try again.');
							},
							complete: function() {
								uploadSpinner.addClass('d-none');
							}
						});
					},
					error: function() {
						alert('Error uploading image. Please try again.');
						uploadSpinner.addClass('d-none');
					}
				});
			});
			
			removeImageBtn.on('click', function() {
				imagePreview.attr('src', '');
				imagePreviewContainer.addClass('d-none');
				imageUpload.val('');
				localStorage.removeItem('characterImage');
				localStorage.removeItem('characterImageNoBg');
				continueBtn.prop('disabled', true);
			});
		});
	</script>
@endpush
