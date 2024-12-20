<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<h4 class="mb-4">{{ __('default.create.step6.title') }}</h4>
		
		<div class="row">
			<div class="col-md-4">
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">Front Cover</h5>
						<img id="previewFrontCover" class="img-fluid" alt="Front Cover">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">Spine</h5>
						<img id="previewSpineCover" class="img-fluid" alt="Spine">
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card mb-3">
					<div class="card-body">
						<h5 class="card-title">Back Cover</h5>
						<img id="previewBackCover" class="img-fluid" alt="Back Cover">
					</div>
				</div>
			</div>
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
		$(document).ready(function() {
			// Load the captured images from localStorage
			const frontCoverImage = localStorage.getItem('frontCoverImage');
			const spineCoverImage = localStorage.getItem('spineCoverImage');
			const backCoverImage = localStorage.getItem('backCoverImage');
			
			if (frontCoverImage) {
				$('#previewFrontCover').attr('src', frontCoverImage);
			}
			if (spineCoverImage) {
				$('#previewSpineCover').attr('src', spineCoverImage);
			}
			if (backCoverImage) {
				$('#previewBackCover').attr('src', backCoverImage);
			}
		});
	</script>
@endpush
