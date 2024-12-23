<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2"
					      stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<h2 class="serif-font mb-4">{{ __('default.create.step1.author_question') }}</h2>
		<p class="text-muted mb-4">{{ __('default.create.step1.author_hint') }}</p>
		
		<div class="mb-4">
			<input type="text"
			       class="form-control form-control-lg bg-light"
			       id="authorName"
			       name="author_name"
			       value="{{ $book->author_name }}"
			       placeholder="{{ __('default.create.step1.author_placeholder') }}"
			       required>
		</div>
		
		<div class="d-grid">
			<button class="btn btn-lg text-white"
			        style="background-color: #dc6832;"
			        id="continueBtn"
				{{ empty($book->author_name) ? 'disabled' : '' }}>
				{{ __('default.create.buttons.continue') }}
			</button>
		</div>
	</div>
</div>

@push('scripts')
	<script>
		$(document).ready(function () {
			$('#authorName').on('input', function () {
				const authorName = $(this).val().trim();
				$('#continueBtn').prop('disabled', !authorName);
			});
			
			$('#continueBtn').on('click', function () {
				const authorName = $('#authorName').val().trim();
				
				$.ajax({
					url: '{{ route("update-book") }}',
					method: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						book_guid: '{{ $book->book_guid }}',
						step: 1,
						author_name: authorName
					},
					success: function(response) {
						if (response.success) {
							window.location.href = '{{ route("create-book") }}?step=2&book_guid={{ $book->book_guid }}';
						}
					},
					error: function(xhr, status, error) {
						console.error('Error saving author name:', error);
						// You might want to show an error message to the user here
					}
				});
			});
			
		});
	</script>
@endpush
