@extends('layouts.app')

@section('title', __('default.Checkout'))

@section('content')
	<div class="container py-5 mt-5">
		<div class="row">
			<div class="col-md-8">
				<div class="card shadow-sm mb-4">
					<div class="card-body">
						<h3 class="mb-4">{{ __('Billing Address') }}</h3>
						<form id="checkout-form">
							@csrf
							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label">{{ __('Name') }}</label>
									<input type="text" class="form-control" name="billing_name" required>
								</div>
								<div class="col-md-6">
									<label class="form-label">{{ __('Email') }}</label>
									<input type="email" class="form-control" name="billing_email" required>
								</div>
								<!-- Add other billing fields -->
							</div>
							
							<h3 class="mt-4 mb-4">{{ __('Shipping Address') }}</h3>
							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label">{{ __('Name') }}</label>
									<input type="text" class="form-control" name="shipping_name" required>
								</div>
								<!-- Add other shipping fields -->
							</div>
							
							<h3 class="mt-4 mb-4">{{ __('Payment Information') }}</h3>
							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label">{{ __('Card Number') }}</label>
									<input type="text" class="form-control" name="card_number" required>
								</div>
								<div class="col-md-3">
									<label class="form-label">{{ __('Expiry') }}</label>
									<input type="text" class="form-control" name="card_expiry" placeholder="MM/YY" required>
								</div>
								<div class="col-md-3">
									<label class="form-label">{{ __('CVV') }}</label>
									<input type="text" class="form-control" name="card_cvv" required>
								</div>
							</div>
							
							<div class="mt-4">
								<button type="submit" class="btn btn-primary btn-lg w-100">
									{{ __('Place Order') }}
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h3 class="mb-4">{{ __('Order Summary') }}</h3>
						
						<div class="book-details mb-4">
							@php
								$bookOptions = json_decode($book->book_options ?? '[]', true);
								$selectedOption = $bookOptions[$book->selected_book_option ?? 0] ?? null;
							@endphp
							<h4>{{ $selectedOption['title'] ?? 'Book Title' }}</h4>
							<p class="text-muted">{{ $book->author_name }}</p>
						</div>
						
						<div class="order-details">
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('Print Size') }}:</span>
								<span>{{ $print_size === 'print_13_19_5_cm' ? '13 x 19.5 cm' : '16 x 20 cm' }}</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('default.checkout.copies') }}:</span>
								<span>{{ $quantity }} x4</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('160 Sayfalık Kitap - İlk 4 Adet') }}:</span>
								<span>{{ number_format($base_price, 2) }} ₺</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('Subtotal') }}:</span>
								<span>{{ number_format($subtotal, 2) }} ₺</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('Shipping') }}:</span>
								<span>{{ $shipping > 0 ? number_format($shipping, 2) . ' ₺' : __('Free') }}</span>
							</div>
							
							<hr>
							
							<div class="d-flex justify-content-between mb-2 fw-bold">
								<span>{{ __('Total') }}:</span>
								<span>{{ number_format($total, 2) }} ₺</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<style>
      .order-details {
          font-size: 0.95rem;
      }

      .book-details h4 {
          margin-bottom: 0.5rem;
          font-size: 1.1rem;
          font-weight: bold;
      }

      .book-details p {
          margin-bottom: 0;
          font-size: 0.9rem;
      }

      [data-bs-theme=dark] .card {
          background-color: #2b3035;
          border-color: #373b3e;
      }

      [data-bs-theme=dark] .text-muted {
          color: #6c757d !important;
      }

      .fw-bold {
          font-size: 1.1rem;
      }
	</style>
	
	@push('scripts')
		<script>
			$(document).ready(function() {
				$('#checkout-form').on('submit', function(e) {
					e.preventDefault();
					
					$.ajax({
						url: '{{ route("checkout.process") }}',
						method: 'POST',
						data: $(this).serialize(),
						success: function(response) {
							if (response.success) {
								window.location.href = response.redirect;
							} else {
								alert(response.message);
							}
						},
						error: function() {
							alert('An error occurred. Please try again.');
						}
					});
				});
			});
		</script>
	@endpush
@endsection
