<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<div class="d-flex justify-content-center align-items-center gap-0">
			<!-- Left div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm" id="front-cover">
				@include('landing.cover1')
			</div>
			<!-- Middle div -->
			<div style="width: 34px; height: 480px;" class="bg-light shadow-sm mx-2" id="spine-cover">
				@include('landing.spine1')
			</div>
			<!-- Right div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm" id="back-cover">
				@include('landing.back1')
			</div>
		</div>
		
		<!-- Cover Style Selector -->
		<div class="d-flex justify-content-center gap-2 mt-4 mb-4">
			@for ($i = 1; $i <= 6; $i++)
				<button class="cover-style-btn rounded-circle d-flex align-items-center justify-content-center"
				        data-style="{{ $i }}"
				        style="width: 40px; height: 40px; border: 2px solid #dc6832; background-color: {{ $i === 1 ? '#dc6832' : 'transparent' }}; color: {{ $i === 1 ? 'white' : '#dc6832' }};">
					{{ $i }}
				</button>
			@endfor
		</div>
		
		<div class="d-grid mt-4">
			<div class="btn btn-lg text-white" style="background-color: #dc6832;" onclick="nextStep()">
				{{ __('default.create.buttons.continue') }}
			</div>
		</div>
	</div>
</div>

@push('scripts')
	<script>
		
		const bookData = {
			title: "REALTY GONE ROGUE!",
			subtitle: "Chronicles of Mischief with Mick and Lara in the Home-Buying World",
			authorName: "Lala Lulu"
		};
		
		let authorImage = "/storage/author-images/large/" + localStorage.getItem('characterImageNoBg');
		
		function applyCoverTextFields(cover_part) {
			if (cover_part === 'front') {
				$('.title').text(bookData.title);
				$('.subtitle').text(bookData.subtitle);
				$('.author-name').text(bookData.authorName);
				$('.author-image').attr('src', authorImage);
			}
			
			if (cover_part === 'spine') {
				$('.spine-title').text(bookData.title);
				$('.spine-author-name').text(bookData.authorName);
			}
			
			if (cover_part === 'back') {
				$('.back-main-title').text('PRAISES FOR ' + bookData.title + '!');
				$('.review-text-1').text('“In \'' + bookData.title + '\', LaLa La perfectly captures the insanity and hilarity of the real estate realm. Mick and Lara\'s antics will have readers laughing out loud from page one. A must-read for anyone looking for a humorous escape from the everyday grind.”');
				$('.review-source-1').text('—Bookish Buzz');
			}
		}
		
		$(document).ready(function () {
			$('.cover-style-btn').on('click', function() {
				const styleNumber = $(this).data('style');
				
				// Update button styles
				$('.cover-style-btn').css({
					'background-color': 'transparent',
					'color': '#dc6832'
				});
				$(this).css({
					'background-color': '#dc6832',
					'color': 'white'
				});
				
				// Load front cover
				$.get(`{{ route('load-cover') }}/${styleNumber}`, function(response) {
					$('#front-cover').html(response);
					applyCoverTextFields('front');
				});
				
				// Load spine
				$.get(`{{ route('load-spine') }}/${styleNumber}`, function(response) {
					$('#spine-cover').html(response);
					applyCoverTextFields('spine');
				});
				
				// Load back cover
				$.get(`{{ route('load-back') }}/${styleNumber}`, function(response) {
					$('#back-cover').html(response);
					applyCoverTextFields('back');
				});
				
				// Save selected style to localStorage
				localStorage.setItem('selectedCoverStyle', styleNumber);
			});
			
			// Load saved style on page load
			const savedStyle = localStorage.getItem('selectedCoverStyle');
			if (savedStyle) {
				$(`.cover-style-btn[data-style="${savedStyle}"]`).click();
			}
		});
	</script>
	
	<style>
      .cover-style-btn {
          transition: all 0.3s ease;
          cursor: pointer;
          border: 2px solid #dc6832;
          outline: none;
      }

      .cover-style-btn:hover {
          transform: scale(1.1);
      }

      [data-bs-theme=dark] .cover-style-btn {
          border-color: #dc6832;
      }
	</style>
@endpush
