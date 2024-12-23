<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		<div class="d-flex justify-content-between align-items-center mb-4">
			<h2 class="serif-font mb-0">{{ __('default.create.step3.title') }}</h2>
			<div id="regenerateBtn" class="btn btn-dark">
				<i class="bi bi-arrow-clockwise"></i> {{ __('default.create.buttons.regenerate') }}
			</div>
		</div>
		
		<!-- Loading spinner -->
		<div id="loadingSpinner" class="text-center my-5 d-none">
			<div class="spinner-border text-primary" role="status">
				<span class="visually-hidden">{{ __('default.create.step3.loading') }}</span>
			</div>
		</div>
		
		<!-- Book suggestions container -->
		<div id="bookSuggestions">
			<!-- Book suggestions will be inserted here -->
		</div>
		
		<div class="d-grid mt-4">
			<button class="btn btn-lg text-white" style="background-color: #dc6832;" id="continueBtn">
				{{ __('default.create.buttons.continue') }}
			</button>
		</div>
	</div>
</div>

@push('scripts')
	<script>
		function getBookSuggestions() {
			$('#loadingSpinner').removeClass('d-none');
			$('#bookSuggestions').empty();
			$('#regenerateBtn').hide();
			$('#continueBtn').prop('disabled', true);
			
			$.ajax({
				url: "{{ route('suggest-book-title-and-short-description') }}",
				method: 'POST',
				dataType: 'json',
				data: {
					author_name: '{{ $book->author_name }}',
					user_answers: @json($book->questions_and_answers ?? []),
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					$('#loadingSpinner').addClass('d-none');
					$('#regenerateBtn').show();
					
					try {
						if (response.suggestions && Array.isArray(response.suggestions)) {
							// Save suggestions to database
							saveSuggestionsToDatabase(response.suggestions);
							renderBookSuggestions(response.suggestions);
						} else {
							console.error('Suggestions not found in the response');
							$('#bookSuggestions').html('<div class="alert alert-danger">{{ __("default.create.step3.error.loading_error") }}</div>');
						}
					} catch (e) {
						console.error('Error parsing suggestions:', e);
						$('#bookSuggestions').html('<div class="alert alert-danger">{{ __("default.create.step3.error.loading_error") }}</div>');
					}
				},
				error: function() {
					$('#regenerateBtn').show();
					$('#loadingSpinner').addClass('d-none');
					$('#bookSuggestions').html('<div class="alert alert-danger">{{ __("default.create.step3.error.loading_error") }}</div>');
				}
			});
		}
		
		function saveSuggestionsToDatabase(suggestions) {
			$.ajax({
				url: '{{ route("update-book") }}',
				method: 'POST',
				data: {
					_token: '{{ csrf_token() }}',
					book_guid: '{{ $book->book_guid }}',
					step: 3,
					suggestions: suggestions,
					selected_option: -1
				}
			});
		}
		
		function renderBookSuggestions(suggestions) {
			$('#bookSuggestions').empty();
			const selectedOption = {{ $book->selected_book_option ?? 'null' }};
			
			suggestions.forEach((suggestion, index) => {
				const isSelected = index === selectedOption;
				const suggestionHtml = `
            <div class="card mb-3 suggestion-card ${isSelected ? 'selected' : ''}"
                 data-index="${index}"
                 style="cursor: pointer; ${isSelected ? 'border: 2px solid #dc6832;' : ''}">
                <div class="card-body">
                    <h3 class="card-title">${suggestion.title}</h3>
                    <p class="text-muted">{{ __('default.create.step3.author_prefix') }} {{ $book->author_name }}</p>
                    <p class="card-text">${suggestion.short_description}</p>
                </div>
            </div>`;
				$('#bookSuggestions').append(suggestionHtml);
			});
		}
		
		$(document).ready(function() {
			$('#continueBtn').prop('disabled', true);
			
			const bookOptions = {!! $book->book_options ?? 'null' !!};
			if (bookOptions) {
				renderBookSuggestions(bookOptions);
				$('#continueBtn').prop('disabled', {{ ($book->selected_book_option >= 0 ? 'false' : 'true') }});
			} else {
				getBookSuggestions();
			}
			
			$('#regenerateBtn').click(function() {
				getBookSuggestions();
			});
			
			$(document).on('click', '.suggestion-card', function() {
				$('.suggestion-card').removeClass('selected').css('border', 'none');
				$(this).addClass('selected').css('border', '2px solid #dc6832');
				
				const selectedIndex = $(this).data('index');
				
				// Save selected option to database
				$.ajax({
					url: '{{ route("update-book") }}',
					method: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						book_guid: '{{ $book->book_guid }}',
						step: 3,
						selected_option: selectedIndex
					}
				});
				
				$('#continueBtn').prop('disabled', false);
			});
			
			$('#continueBtn').on('click', function() {
				window.location.href = '{{ route("create-book") }}?step=4&book_guid={{ $book->book_guid }}';
			});
		});
	</script>
@endpush
