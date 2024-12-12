@extends('layouts.app')

@section('title', 'Create Book - Step 1')

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
          background-color: #e9ecef;
          display: flex;
          align-items: center;
          justify-content: center;
          font-weight: bold;
          z-index: 1;
      }

      .wizard-progress-step.active {
          background-color: #dc6832;
          color: white;
      }

      .wizard-progress-bar {
          position: absolute;
          top: 15px;
          left: 0;
          right: 0;
          height: 2px;
          background-color: #e9ecef;
          z-index: 0;
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
						<div class="card shadow-sm">
							<div class="card-body p-4">
								<div class="mb-4">
									<button class="back-button btn btn-link p-0" style="text-decoration: none;">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
								</div>
								
								<h2 class="serif-font mb-4">{{ __('default.create.step1.author_question') }}</h2>
								<p class="text-muted mb-4">{{ __('default.create.step1.author_hint') }}</p>
								
								<div class="mb-4">
									<input type="text"
									       class="form-control form-control-lg bg-light"
									       id="authorName"
									       name="author_name"
									       placeholder="{{ __('default.create.step1.author_placeholder') }}"
									       required>
								</div>
								
								<div class="d-grid">
									<button type="button"
									        class="btn btn-lg text-white"
									        style="background-color: #dc6832;"
									        onclick="nextStep()">
										{{ __('default.create.buttons.continue') }}
									</button>
								</div>
							</div>
						</div>
					</div>
					
					
					<!-- Additional steps will be here but hidden initially -->
					<div class="wizard-step d-none" id="step2">
						
						<div class="card shadow-sm">
							<div class="card-body p-4">
								<div class="mb-4">
									<button class="back-button btn btn-link p-0" style="text-decoration: none;">
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
									</button>
								</div>
							</div>
						</div>
						<!-- Step 2 content -->
					</div>
					
					<div class="wizard-step d-none" id="step3">
						<!-- Step 3 content -->
					</div>
					
					<div class="wizard-step d-none" id="step4">
						<!-- Step 4 content -->
					</div>
				</form>
			</div>
		</div>
	</div>
	
	@include('layouts.footer')
@endsection

@push('scripts')
	<script>
		var current_page = 'my.create-book';
		var currentStep = 1;
		
		$(document).ready(function () {
			updateProgressBar();
			
			$(".back-button").on('click', function (e) {
				if (currentStep === 1) {
					// If on first step, redirect to landing page
					window.location.href = "{{ route('landing-page') }}";
				} else {
					// If not on first step, go back one step
					previousStep();
				}
				e.preventDefault();
			});
		});
		
		
		function nextStep() {
			if (validateCurrentStep()) {
				if (currentStep < 7) {
					$(`#step${currentStep}`).addClass('d-none');
					currentStep++;
					$(`#step${currentStep}`).removeClass('d-none');
					updateProgressBar();
				}
			}
		}
		
		function previousStep() {
			if (currentStep > 1) {
				$(`#step${currentStep}`).addClass('d-none');
				currentStep--;
				$(`#step${currentStep}`).removeClass('d-none');
				updateProgressBar();
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
				}
			}
			// Add validation for other steps as needed
			
			return valid;
		}
	</script>
@endpush
