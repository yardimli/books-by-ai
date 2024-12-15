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
			<div class="btn btn-lg text-white mt-3"
			     style="background-color: #dc6832;"
			     onclick="nextStep()">
				{{ __('default.create.buttons.continue') }}
			</div>
		</div>
	</div>
</div>

@push('scripts')
	<script>
		function getBookSuggestions() {
			$('#loadingSpinner').removeClass('d-none');
			$('#bookSuggestions').empty();
			$('#regenerateBtn').hide();
			
			const userAnswers = answers.map(a => `Question: ${a.question}\nAnswer: ${a.answer}`).join('\n\n');
			
			$.ajax({
				url: "{{ route('suggest-book-title-and-short-description') }}",
				method: 'POST',
				dataType: 'json',
				data: {
					user_answers: userAnswers,
					_token: $('meta[name="csrf-token"]').attr('content')
				},
				success: function (response) {
					$('#loadingSpinner').addClass('d-none');
					$('#regenerateBtn').show();
					try {
						if (response.suggestions && Array.isArray(response.suggestions)) {
							// Store suggestions in localStorage
							bookSuggestions = response.suggestions;
							localStorage.setItem('bookSuggestions', JSON.stringify(bookSuggestions));
							renderBookSuggestions();
						} else {
							console.error('Suggestions not found in the response');
							$('#bookSuggestions').html('<div class="alert alert-danger">{{ __("default.create.step3.error.loading_error") }}</div>');
						}
					} catch (e) {
						console.error('Error parsing suggestions:', e);
						$('#bookSuggestions').html('<div class="alert alert-danger">{{ __("default.create.step3.error.loading_error") }}</div>');
					}
				},
				error: function () {
					$('#regenerateBtn').show();
					$('#loadingSpinner').addClass('d-none');
					$('#bookSuggestions').html('<div class="alert alert-danger">{{ __("default.create.step3.error.loading_error") }}</div>');
				}
			});
		}
		
		function renderBookSuggestions() {
			$('#bookSuggestions').empty();
			
			bookSuggestions.forEach((suggestion, index) => {
				const isSelected = index.toString() === selectedSuggestionIndex;
				const suggestionHtml = `
            <div class="card mb-3 suggestion-card ${isSelected ? 'selected' : ''}"
                 data-index="${index}"
                 style="cursor: pointer; ${isSelected ? 'border: 2px solid #dc6832;' : ''}">
                <div class="card-body">
                    <h3 class="card-title">${suggestion.title}</h3>
                    <p class="text-muted">{{ __('default.create.step3.author_prefix') }} ${localStorage.getItem('authorName')}</p>
                    <p class="card-text">${suggestion.short_description}</p>
                </div>
            </div>
        `;
				$('#bookSuggestions').append(suggestionHtml);
			});
		}
		
		$(document).ready(function () {
			
			// Regenerate button click handler
			$('#regenerateBtn').click(function () {
				getBookSuggestions();
			});
			
			$(document).on('click', '.suggestion-card', function () {
				$('.suggestion-card').removeClass('selected').css('border', 'none');
				$(this).addClass('selected').css('border', '2px solid #dc6832');
				selectedSuggestionIndex = $(this).data('index').toString();
				localStorage.setItem('selectedSuggestionIndex', selectedSuggestionIndex);
			});
			
			
		});
	</script>
@endpush

