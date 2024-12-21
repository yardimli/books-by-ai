@extends('layouts.app')

@section('title', 'Create Book')

@section('content')
	<script src="/js/html2canvas.min.js"></script>
	
	<style>

      @include('landing.create-book-fonts')

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
          padding: 1.0rem;
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
				
				@php
					$currentStep = (int)request()->query('step', 1);
				@endphp
				
				
				<div class="wizard-step">
					@switch($currentStep)
						@case(1)
							@include('landing.create-step-1')
							@break
						@case(2)
							@include('landing.create-step-2')
							@break
						@case(3)
							@include('landing.create-step-3')
							@break
						@case(4)
							@include('landing.create-step-4')
							@break
						@case(5)
							@include('landing.create-step-5')
							@break
						@case(6)
							@include('landing.create-step-6')
							@break
						@case(7)
							@include('landing.create-step-7')
							@break
						@default
							@include('landing.create-step-1')
					@endswitch
				</div>
				
			</div>
		</div>
	</div>
	
	@include('layouts.footer')
@endsection

@push('scripts')
	<script>
		let current_page = 'my.create-book';
		let currentStep = 1;
		
		// Modify the nextStep function
		function nextStep() {
			if (validateCurrentStep(currentStep)) {
				if (currentStep < 7) {
					window.location.href = `{{ route('create-book') }}?step=${currentStep + 1}`;
				}
			} else {
				console.log('Validation failed');
			}
		}
		
		function previousStep() {
			if (currentStep > 1) {
				window.location.href = `${window.location.pathname}?step=${currentStep - 1}`;
			}
		}
		
		function updateProgressBar() {
			$('.wizard-progress-step').removeClass('active');
			for (let i = 1; i <= currentStep; i++) {
				$(`.wizard-progress-step:nth-child(${i + 1})`).addClass('active');
			}
		}
		
		function validateCurrentStep(currentStep) {
			let valid = true;
			console.log('Validating step', currentStep);
			if (currentStep === 1) {
				const authorName = localStorage.getItem('authorName');
				if (!authorName) {
					valid = false;
				}
			}
			
			if (currentStep === 2) {
				let answers = JSON.parse(localStorage.getItem('bookAnswers')) || [];
				if (answers.length === 0) {
					valid = false;
				}
			}
			
			if (currentStep === 3) {
				const storedSuggestions = localStorage.getItem('bookSuggestions');
				const selectedSuggestionIndex = localStorage.getItem('selectedSuggestionIndex');
				if (storedSuggestions && selectedSuggestionIndex && storedSuggestions.length > 0 && selectedSuggestionIndex >= 0) {
				} else
				{
					valid = false;
				}
			}
			
			if (currentStep === 4) {
				const authorImage = localStorage.getItem('authorImage');
				if (!authorImage) {
					valid = false;
				}
			}
			
			if (currentStep === 5) {
				const savedStyle = localStorage.getItem('selectedCoverStyle') ?? '';
				if (savedStyle === '') {
					valid = false;
				}
				const savedFrontImage = localStorage.getItem('frontCoverImage') ?? '';
				if (savedFrontImage === '') {
					valid = false;
				}
			}
			if (valid) {
				console.log('Step', currentStep, 'is valid');
			} else {
				console.log('Step', currentStep, 'is invalid');
			}
			
			return valid;
		}
		
		
		$(document).ready(function () {
			// Get initial step from URL
			const urlParams = new URLSearchParams(window.location.search);
			currentStep = parseInt(urlParams.get('step')) || 1;
			console.log('Current step:', currentStep);
			
			//validate all previous steps
			if (currentStep>1) {
				for (let i = 1; i < currentStep; i++) {
					if (!validateCurrentStep(i)) {
						window.location.href = `{{ route('create-book') }}?step=${i}`;
					}
				}
			}
				
				
				// Update progress bar
			updateProgressBar();
	
			if (currentStep === 6) {
				updateBookCoverPreview();
			}
			
			$(".back-button").on('click', function (e) {
				e.preventDefault();
				if (currentStep === 1) {
					window.location.href = "{{ route('landing-page') }}";
				} else {
					window.location.href = `{{ route('create-book') }}?step=${currentStep - 1}`;
				}
			});
			
		});
	
	</script>
@endpush
