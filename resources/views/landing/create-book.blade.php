@extends('layouts.app')

@php
	$currentStep = (int)request()->query('adim', 1);
	$bookOptions = json_decode($book->book_options ?? '[]', true);
	$selectedOption = $bookOptions[$book->selected_book_option ?? 0] ?? null;
	$bookTitle = $selectedOption['title'] ?? '';
	
	// Define step titles
	$stepTitles = [
			1 => __('default.create.step1.page_title'),
			2 => __('default.create.step2.page_title', ['author' => $book->author_name]),
			3 => __('default.create.step3.page_title', ['author' => $book->author_name]),
			4 => __('default.create.step4.page_title', ['author' => $book->author_name]),
			5 => __('default.create.step5.page_title', ['author' => $book->author_name, 'title' => $bookTitle]),
			6 => __('default.create.step6.page_title', ['author' => $book->author_name, 'title' => $bookTitle]),
			7 => __('default.create.step7.page_title', ['author' => $book->author_name, 'title' => $bookTitle])
	];
	
	$pageTitle = $stepTitles[$currentStep] ?? $stepTitles[1];
@endphp

@section('title', $pageTitle)

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
          background-color: #d9dcdf !important;
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
          color: white !important;
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

      .alert {
          margin-bottom: 20px;
          border-radius: 8px;
      }
      .alert-danger {
          background-color: rgba(220, 53, 69, 0.1);
          border-color: rgba(220, 53, 69, 0.2);
          color: #dc3545;
      }
      [data-bs-theme=dark] .alert-danger {
          background-color: rgba(220, 53, 69, 0.2);
          border-color: rgba(220, 53, 69, 0.3);
          color: #ff6b6b;
      }
	
	
	</style>
	
	<div class="container py-5 mt-5" style="min-height: calc(100vh);">
		<div class="row justify-content-center">
			<div class="col-md-8">
				
				<div class="wizard-progress mb-5">
					<div class="wizard-progress-bar"></div>
					<a href="{{ route('create-book') }}?adim=1&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">1</a>
					<a href="{{ route('create-book') }}?adim=2&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">2</a>
					<a href="{{ route('create-book') }}?adim=3&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">3</a>
					<a href="{{ route('create-book') }}?adim=4&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">4</a>
					<a href="{{ route('create-book') }}?adim=5&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">5</a>
					<a href="{{ route('create-book') }}?adim=6&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">6</a>
					<a href="{{ route('create-book') }}?adim=7&kitap_kodu={{ $book->book_guid }}" class="wizard-progress-step">7</a>
				</div>
				
				@if(session('error'))
					<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
						{{ session('error') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
				
				@php
					$currentStep = (int)request()->query('adim', 1);
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
		
		
		function saveBookData(step, data) {
			$.ajax({
				url: '{{ route("update-book") }}',
				method: 'POST',
				data: {
					_token: '{{ csrf_token() }}',
					book_guid: '{{ $book->book_guid }}',
					step: step,
					...data
				},
				success: function (response) {
					if (response.success) {
						window.location.href = `{{ route('create-book') }}?adim=${step + 1}&kitap_kodu={{ $book->book_guid }}`;
					}
				}
			});
		}
		
		function previousStep() {
			if (currentStep > 1) {
				window.location.href = `${window.location.pathname}?adim=${currentStep - 1}`;
			}
		}
		
		function updateProgressBar() {
			$('.wizard-progress-step').removeClass('active');
			for (let i = 1; i <= currentStep; i++) {
				$(`.wizard-progress-step:nth-child(${i + 1})`).addClass('active');
			}
		}
		
		$(document).ready(function () {
			// Get initial step from URL
			const urlParams = new URLSearchParams(window.location.search);
			currentStep = parseInt(urlParams.get('adim')) || 1;
			console.log('Current step:', currentStep);
			
			// Update progress bar
			updateProgressBar();
			
			$(".back-button").on('click', function (e) {
				e.preventDefault();
				if (currentStep === 1) {
					window.location.href = "{{ route('landing-page') }}";
				} else {
					window.location.href = `{{ route('create-book') }}?adim=${currentStep - 1}&kitap_kodu={{ $book->book_guid }}`;
				}
			});
			
		});
	
	</script>
@endpush
