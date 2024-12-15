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
		
		<h2
			class="serif-font mb-4">{!! __('default.create.step2.title', ['author' => '<span class="author_name"></span>']) !!}</h2>
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
			<div class="btn btn-lg text-white" style="background-color: #dc6832;"
			     onclick="nextStep()">
				{{ __('default.create.buttons.continue') }}
			</div>
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
			<div class="modal-body">
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




@push('scripts')
	<script>
		function renderAnswers() {
			const authorName = localStorage.getItem('authorName') || '';
			const answersHtml = answers.map((item, index) => `
            <div class="card bg-light mb-3 position-relative">
                <div class="position-absolute top-0 end-0 m-2">
                    <div class="btn btn-link text-danger p-0" onclick="deleteAnswer(${index})" style="line-height: 1;">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">${item.question.replace('#author#', authorName)}</h5>
                    <p class="card-text">${item.answer}</p>
                </div>
            </div>
        `).join('');
			
			$('#previous-answers').html(answersHtml);
		}
		
		function buildQuestionsList() {
			const questionsList = $('#questionsList');
			questionsList.empty();
			
			Object.entries(window.bookQuestions).forEach(([key, question]) => {
				const authorName = localStorage.getItem('authorName') || '';
				const questionText = question.replace('#author#', authorName);
				
				const questionButton = $(`
                <div class="list-group-item list-group-item-action">
                    ${questionText}
                </div>
            `);
				
				questionButton.data('original-question', question); // Store original question with #author# placeholder
				questionsList.append(questionButton);
			});
		}
		
		$(document).ready(function () {
			
			// Question selection button click
			$('#selectQuestionBtn').click(function (e) {
				buildQuestionsList(); // Rebuild questions list with current author name
				$('#questionModal').modal('show');
				e.preventDefault();
			});
			
			// Question selection
			$(document).on('click', '#questionsList .list-group-item', function () {
				const originalQuestion = $(this).data('original-question');
				const authorName = localStorage.getItem('authorName') || '';
				const questionText = originalQuestion.replace('#author#', authorName);
				
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
					answers.push({
						question: originalQuestion, // Store the original question with placeholder
						answer: answer
					});
					
					localStorage.setItem('bookAnswers', JSON.stringify(answers));
					renderAnswers();
					
					$('#answerModal').modal('hide');
					$('#answerText').val('');
					e.preventDefault();
				}
			});
			
			window.deleteAnswer = function (index) {
				answers.splice(index, 1);
				localStorage.setItem('bookAnswers', JSON.stringify(answers));
				renderAnswers();
			}
			
		});
	</script>
@endpush
