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
		
		<div class="d-flex justify-content-center align-items-center gap-0">
			<!-- Left div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm">
				@include('landing.cover1')
			</div>
			
			<!-- Middle div -->
			<div style="width: 34px; height: 480px;" class="bg-light shadow-sm mx-2">
				@include('landing.spine1')
			</div>
			
			<!-- Right div -->
			<div style="width: 320px; height: 480px;" class="bg-light shadow-sm">
				@include('landing.back1')
			</div>
		</div>
		
		<div class="d-grid mt-4">
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

