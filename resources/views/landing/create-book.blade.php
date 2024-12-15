@extends('layouts.app')

@section('title', 'Create Book')

@section('content')
	<style>
      .serif-font {
          font-family: Georgia, Times, "Times New Roman", serif;
      }

      .wizard-progress {
          position: relative;
          display: flex;
          justify-content: space-between;
          margin-bottom: 3rem;
          padding: 0 40px;
      }

      .wizard-progress-step {
          position: relative;
          width: 30px;
          height: 30px;
          border-radius: 50%;
          background-color: #d9dcdf;
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: bold;
          z-index: 1;
      }

      [data-bs-theme=dark] .wizard-progress-step {
          background-color: #343a40 !important;
      }

      .wizard-progress-step.active {
          background-color: #dc6832 !important;
          color: white;
      }

      .wizard-progress-bar {
          position: absolute;
          top: 15px;
          left: 0;
          right: 0;
          height: 2px;
          background-color: #d9dcdf;
          z-index: 0;
      }

      [data-bs-theme=dark] .wizard-progress-bar {
          background-color: #343a40;
      }

      .modal-content {
          border-radius: 15px;
      }

      .list-group-item {
          cursor: pointer;
          border: none;
          padding: 1rem;
      }

      .list-group-item:hover {
          background-color: rgba(255, 255, 255, 0.1) !important;
      }

      #answerText {
          border: 1px solid rgba(255, 255, 255, 0.2);
      }

      #answerText:focus {
          border-color: #dc6832;
          box-shadow: none;
      }

      .suggestion-card {
          transition: all 0.3s ease;
      }

      .suggestion-card:hover {
          transform: translateY(-2px);
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }

      .suggestion-card.selected {
          border: 2px solid #dc6832;
      }

      .back-button {
          cursor: pointer;
      }

      .text-muted {
          color: #6c757d !important;
      }

      [data-bs-theme=dark] .text-muted {
          color: #adb5bd !important;
      }

      .modal-content {
          background-color: #e9ecef !important;
      }

      [data-bs-theme=dark] .modal-content {
          background-color: #343a40 !important;
      }

      [data-bs-theme=dark] .bg-light {
          background-color: #343a40 !important;
      }
	
	
	</style>
	
	<div class="container py-5 mt-5" style="min-height: calc(100vh);">
		
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="wizard-progress mb-5">
					<div class="wizard-progress-bar"></div>
					<div class="wizard-progress-step active">1</div>
					<div class="wizard-progress-step">2</div>
					<div class="wizard-progress-step">3</div>
					<div class="wizard-progress-step">4</div>
					<div class="wizard-progress-step">5</div>
					<div class="wizard-progress-step">6</div>
					<div class="wizard-progress-step">7</div>
				</div>
				
				<form id="createBookForm" method="POST" action="{{ route('save-book') }}">
					@csrf
					<div class="wizard-step" id="step1">
						@include('landing.create-step-1')
					</div>
					
					
					<!-- Additional steps will be here but hidden initially -->
					<!-- Step 2 content -->
					<div class="wizard-step d-none" id="step2">
						@include('landing.create-step-2')
					</div>
					
					<div class="wizard-step d-none" id="step3">
						@include('landing.create-step-3')
					</div>
					
					<div class="wizard-step d-none" id="step4">
						@include('landing.create-step-4')
					</div>
					
					<div class="wizard-step d-none" id="step5">
						@include('landing.create-step-5')
					</div>
					
					<div class="wizard-step d-none" id="step6">
						@include('landing.create-step-6')
					</div>
					
					<div class="wizard-step d-none" id="step7">
						@include('landing.create-step-7')
					</div>
				
				</form>
			</div>
		</div>
	</div>
	
	@include('layouts.footer')
@endsection

@php
	$questions = __('default.create.step2.questions');
@endphp

<script>
	window.bookQuestions = @json($questions);
</script>

@push('scripts')
	<script>
		let current_page = 'my.create-book';
		let currentStep = 1;
		let answers = JSON.parse(localStorage.getItem('bookAnswers')) || [];
		let bookSuggestions = JSON.parse(localStorage.getItem('bookSuggestions')) || [];
		let selectedSuggestionIndex = localStorage.getItem('selectedSuggestionIndex') || null;
		
		// Add these functions at the beginning of your script
		function updateURL(step) {
			const url = new URL(window.location);
			url.searchParams.set('step', step);
			window.history.pushState({}, '', url);
		}
		
		function getStepFromURL() {
			const urlParams = new URLSearchParams(window.location.search);
			const step = parseInt(urlParams.get('step'));
			return (step >= 1 && step <= 7) ? step : 1;
		}
		
		function goToStep(step) {
			
			if (!validateStepAccess(step)) {
				// If validation fails, go to the first incomplete step
				step = 1;
				updateURL(step);
			}
			
			// Hide all steps
			$('.wizard-step').addClass('d-none');
			// Show the current step
			$(`#step${step}`).removeClass('d-none');
			currentStep = step;
			updateProgressBar();
			loadStepValues();
			
			// If it's step 3 and we have answers, handle book suggestions
			if (step === 3) {
				if (bookSuggestions.length > 0) {
					renderBookSuggestions();
				} else {
					getBookSuggestions();
				}
			}
		}
		
		// Modify the nextStep function
		function nextStep() {
			if (validateCurrentStep()) {
				if (currentStep < 7) {
					$(`#step${currentStep}`).addClass('d-none');
					currentStep++;
					$(`#step${currentStep}`).removeClass('d-none');
					updateProgressBar();
					updateURL(currentStep);
					
					if (currentStep === 3) {
						if (bookSuggestions.length > 0) {
							renderBookSuggestions();
						} else {
							getBookSuggestions();
						}
					}
				}
			}
		}
		
		// Modify the previousStep function
		function previousStep() {
			if (currentStep > 1) {
				$(`#step${currentStep}`).addClass('d-none');
				currentStep--;
				$(`#step${currentStep}`).removeClass('d-none');
				updateProgressBar();
				updateURL(currentStep);
			}
		}
		
		function validateStepAccess(targetStep) {
			// Add your validation logic here
			// For example, check if previous steps are completed
			if (targetStep === 2 && !localStorage.getItem('authorName')) {
				return false;
			}
			if (targetStep === 3 && (!answers || answers.length === 0)) {
				return false;
			}
			return true;
		}
		
		function loadStepValues() {
			$('.author_name').text(localStorage.getItem('authorName') ?? '');
			if (currentStep === 1) {
				$('#authorName').val(localStorage.getItem('authorName') ?? '');
			}
			if (currentStep === 2) {
				// Load values for step 2
			}
		}
		
		function updateProgressBar() {
			$('.wizard-progress-step').removeClass('active');
			for (let i = 1; i <= currentStep; i++) {
				$(`.wizard-progress-step:nth-child(${i + 1})`).addClass('active');
			}
		}
		
		function validateCurrentStep() {
			let valid = true;
			
			if (currentStep === 1) {
				const authorName = $('#authorName').val().trim();
				if (!authorName) {
					valid = false;
					$('#authorName').addClass('is-invalid');
				} else {
					$('#authorName').removeClass('is-invalid');
					localStorage.setItem('authorName', authorName);
				}
			}
			// Add validation for other steps as needed
			
			return valid;
		}
		
		
		$(document).ready(function () {
			// Get initial step from URL
			currentStep = getStepFromURL();
			goToStep(currentStep);
			
			window.addEventListener('popstate', function(event) {
				const step = getStepFromURL();
				goToStep(step);
			});
			
			
			updateProgressBar();
			loadStepValues();
			renderAnswers();
			
			$(".back-button").on('click', function (e) {
				if (currentStep === 1) {
					// If on first step, redirect to landing page
					window.location.href = "{{ route('landing-page') }}";
				} else {
					// If not on first step, go back one step
					previousStep();
					loadStepValues();
				}
				e.preventDefault();
			});
			
		});
	
	</script>
@endpush
