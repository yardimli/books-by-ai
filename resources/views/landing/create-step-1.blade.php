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
			       placeholder="{{ __('default.create.step1.author_placeholder') }}"
			       required>
		</div>
		
		<div class="d-grid">
			<div class="btn btn-lg text-white"
			     style="background-color: #dc6832;"
			     onclick="nextStep()">
				{{ __('default.create.buttons.continue') }}
			</div>
		</div>
	</div>
</div>

@push('scripts')
	<script>
		$(document).ready(function () {
		
		});
	</script>
@endpush