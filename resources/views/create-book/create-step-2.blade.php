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
		
		<h2 class="inria-serif-regular mb-4">{!! __('default.create.step2.title', ['author' => '<span class="author_name">'.$book->author_name.'</span>']) !!}</h2>
		<p class="text-muted mb-4">{{ __('default.create.step2.subtitle') }}</p>
		
		<!-- Previous answers will be displayed here -->
		<div id="previous-answers" class="mb-4"></div>
		
		<!-- Question selection button -->
		<div class="question-selector mb-4">
			<div class="btn btn-light w-100 text-start p-3" id="selectQuestionBtn">
				{{ __('default.create.step2.select_question') }}
				<span class="float-end">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                    </span>
			</div>
		</div>
		
		<!-- Continue button -->
		<div class="d-grid">
			<button class="btn btn-lg text-white" style="background-color: #dc6832;" id="continueBtn">
				{{ __('default.create.buttons.continue') }}
			</button>
		</div>
	</div>
</div>

<!-- Question Selection Modal -->
<div class="modal fade" id="questionModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<h5 class="modal-title">{{ __('default.create.step2.modal.title') }}</h5>
				<div class="btn-close btn-close-white" data-bs-dismiss="modal"></div>
			</div>
			<div class="modal-body" style="max-height: 300px; overflow-y: auto; overflow-x: hidden;">
				<div class="list-group list-group-flush" id="questionsList">
					<!-- Questions will be inserted here by JavaScript -->
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Answer Modal -->
<div class="modal fade" id="answerModal" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-0">
				<div class="btn-close btn-close-white" data-bs-dismiss="modal"></div>
			</div>
			<div class="modal-body">
				<h5 class="modal-title mb-3" id="selectedQuestion"></h5>
				<textarea class="form-control" id="answerText" rows="4"
				          placeholder="{{ __('default.create.step2.modal.answer_placeholder') }}"></textarea>
			</div>
			<div class="modal-footer border-0">
				<div class="btn btn-primary w-100" id="saveAnswer">
					{{ __('default.create.buttons.save_answer') }}
				</div>
			</div>
		</div>
	</div>
</div>

<style>
    .list-group-item.disabled {
        pointer-events: none;
        cursor: not-allowed;
    }

    .list-group-item.disabled:hover {
        /*background-color: #f8f9fa !important;*/
    }
</style>


@push('scripts')
	<script>
		let answers = [];
		
		function addTurkishPossessiveSuffix(name) {
			name = name.toLowerCase();
			const vowels = name.match(/[aeıioöuü]/g);
			const lastLetter = name.slice(-1);
			const lastVowel = vowels ? vowels[vowels.length - 1] : null;
			
			const isVowel = /[aeıioöuü]/.test(lastLetter);
			
			if (isVowel) {
				switch (lastVowel) {
					case 'a': case 'ı': return 'nın';
					case 'e': case 'i': return 'nin';
					case 'o': case 'u': return 'nun';
					case 'ö': case 'ü': return 'nün';
				}
			} else {
				switch (lastVowel) {
					case 'a': case 'ı': return 'ın';
					case 'e': case 'i': return 'in';
					case 'o': case 'u': return 'un';
					case 'ö': case 'ü': return 'ün';
				}
			}
			return 'ın';
		}
		
		function renderAnswers(answers) {
			const authorName = '{{ $book->author_name }}';
			const answersHtml = answers.map((item, index) => {
				let questionText = item.question;
				if (questionText.includes('[suffix]')) {
					const suffix = addTurkishPossessiveSuffix(authorName);
					questionText = questionText.replace('#author#[suffix]', `${authorName}'${suffix}`);
				} else {
					questionText = questionText.replace('#author#', authorName);
				}
				
				return `
            <div class="card bg-light mb-3 position-relative">
                <div class="position-absolute top-0 end-0 m-2">
                    <div class="btn btn-link text-danger p-0" onclick="deleteAnswer(${index})" style="line-height: 1;">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">${questionText}</h5>
                    <p class="card-text">${item.answer}</p>
                </div>
            </div>
        `;
			}).join('');
			$('#previous-answers').html(answersHtml);
		}
		
		function buildQuestionsList() {
			const questionsList = $('#questionsList');
			questionsList.empty();
			let bookQuestions = @json(__('default.create.step2.questions'));
			const authorName = '{{ $book->author_name }}';
			
			Object.entries(bookQuestions).forEach(([key, question]) => {
				let questionText = question;
				if (questionText.includes('[suffix]')) {
					const suffix = addTurkishPossessiveSuffix(authorName);
					questionText = questionText.replace('#author#[suffix]', `${authorName}'${suffix}`);
				} else {
					questionText = questionText.replace('#author#', authorName);
				}
				
				// Check if question has already been answered
				const isAnswered = answers.some(answer => answer.question === questionText);
				
				const questionButton = $(`
            <div class="list-group-item list-group-item-action ${isAnswered ? 'disabled' : ''}">
                ${questionText}
                ${isAnswered ? '<span class="float-end text-success"><i class="bi bi-check-circle-fill"></i></span>' : ''}
            </div>
        `);
				questionButton.data('original-question', question);
				questionButton.data('is-answered', isAnswered);
				questionsList.append(questionButton);
			});
		}
		
		
		function checkIfHasAnswers(answers) {
			if (answers.length === 0) {
				$('#continueBtn').prop('disabled', true);
				return false;
			} else {
				$('#continueBtn').prop('disabled', false);
				return true;
			}
		}
		
		$(document).ready(function () {
			const savedAnswers = {!! $book->questions_and_answers ?? '[]' !!};
			answers = typeof savedAnswers === 'string' ? JSON.parse(savedAnswers) : savedAnswers;
			renderAnswers(answers);
			checkIfHasAnswers(answers);
			
			// Question selection button click
			$('#selectQuestionBtn').click(function (e) {
				buildQuestionsList(); // Rebuild questions list with current author name
				$('#questionModal').modal('show');
				e.preventDefault();
			});
			
			// Question selection
			// Question selection
			$(document).on('click', '#questionsList .list-group-item', function () {
				// If question is already answered, don't do anything
				if ($(this).data('is-answered')) {
					return;
				}
				
				const originalQuestion = $(this).data('original-question');
				let questionText = originalQuestion;
				const authorName = '{{ $book->author_name }}';
				
				if (questionText.includes('[suffix]')) {
					const suffix = addTurkishPossessiveSuffix(authorName);
					questionText = questionText.replace('#author#[suffix]', `${authorName}'${suffix}`);
				} else {
					questionText = questionText.replace('#author#', authorName);
				}
				
				$('#selectedQuestion').text(questionText);
				$('#questionModal').modal('hide');
				$('#answerModal').modal('show');
			});
			
			// Save answer
			$('#saveAnswer').click(function (e) {
				const question = $('#selectedQuestion').text();
				const originalQuestion = $('#questionModal .list-group-item')
					.filter(function () {
						return $(this).text() === question;
					})
					.data('original-question') || question;
				const answer = $('#answerText').val();
				
				if (answer.trim()) {
					// Check if question has already been answered
					if (answers.some(a => a.question === originalQuestion)) {
						alert('This question has already been answered.');
						return;
					}
					
					answers.push({
						question: originalQuestion,
						answer: answer
					});
					
					// Save to database
					$.ajax({
						url: '{{ route("update-book") }}',
						method: 'POST',
						data: {
							_token: '{{ csrf_token() }}',
							book_guid: '{{ $book->book_guid }}',
							step: 2,
							answers: answers
						},
						success: function(response) {
							if (response.success) {
								renderAnswers(answers);
								checkIfHasAnswers(answers);
								$('#answerModal').modal('hide');
								$('#answerText').val('');
								buildQuestionsList(); // Rebuild questions list to update UI
							}
						}
					});
					e.preventDefault();
				}
			});
			
			window.deleteAnswer = function (index) {
				answers.splice(index, 1);
				
				// Save updated answers to database
				$.ajax({
					url: '{{ route("update-book") }}',
					method: 'POST',
					data: {
						_token: '{{ csrf_token() }}',
						book_guid: '{{ $book->book_guid }}',
						step: 2,
						answers: answers
					},
					success: function(response) {
						if (response.success) {
							renderAnswers(answers);
							checkIfHasAnswers(answers);
							buildQuestionsList(); // Rebuild questions list to update UI
						}
					}
				});
			}
			
			
			$('#continueBtn').on('click', function() {
				window.location.href = '{{ route("create-book") }}?adim=3&kitap_kodu={{ $book->book_guid }}';
			});
		});
	</script>
@endpush
