@extends('layouts.app')

@section('title', __('default.Checkout'))

@section('content')
	<div class="container py-5 mt-5">
		<div class="row">
			<div class="col-md-8">
				<div class="card shadow-sm mb-4">
					<div class="card-body">
						
						
						<form id="checkout-form">
							@csrf
							<input type="hidden" name="book_guid" value="{{ $book->book_guid }}">
							<input type="hidden" name="quantity" id="quantity" value="{{$quantity}}">
							<input type="hidden" name="print_size" id="print_size" value="{{$print_size}}">
							
							<!-- Billing Address -->
							<h3 class="mb-4">{{ __('default.Billing Address') }}</h3>
							<div class="row g-3 mb-4">
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Name and Surname') }}</label>
									<input type="text" class="form-control" name="billing_name" id="billing_name" required>
								</div>
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Phone') }}</label>
									<input type="tel" class="form-control" name="billing_phone" id="billing_phone" required>
								</div>
								<div class="col-12">
									<label class="form-label">{{ __('default.Address') }}</label>
									<input type="text" class="form-control" name="billing_address" id="billing_address" required>
								</div>
								<!-- Billing Address City Section -->
								<div class="col-md-6 billing-location-dropdowns">
									<label class="form-label">{{ __('default.City') }}</label>
									<!-- Dropdown fields for Turkey -->
									<select class="form-control city-select" id="billing_city_select" name="billing_city_select"
									        data-type="billing" disabled>
										<option value="">{{ __('default.Select City') }}</option>
									</select>
								</div>
								<div class="col-md-6 billing-location-dropdowns">
									<label class="form-label">{{ __('default.County') }}</label>
									<select class="form-control county-select" id="billing_county_select" name="billing_county_select"
									        data-type="billing" disabled>
										<option value="">{{ __('default.Select County') }}</option>
									</select>
								</div>
								<div class="col-md-6 billing-location-dropdowns">
									<label class="form-label">{{ __('default.District') }}</label>
									<select class="form-control district-select" id="billing_district_select"
									        name="billing_district_select" data-type="billing"
									        disabled>
										<option value="">{{ __('default.Select District') }}</option>
									</select>
								</div>
								<div class="col-md-6 billing-location-dropdowns">
									<label class="form-label">{{ __('default.Neighborhood') }}</label>
									<select class="form-control neighborhood-select" id="billing_neighborhood_select"
									        name="billing_neighborhood_select" data-type="billing"
									        disabled>
										<option value="">{{ __('default.Select Neighborhood') }}</option>
									</select>
								</div>
								
								
								<div class="col-md-6 billing-location-text">
									<label class="form-label">{{ __('default.City') }}</label>
									<input type="text" class="form-control" name="billing_city" id="billing_city">
								</div>
								<div class="col-md-6">
									<label class="form-label">{{ __('default.ZIP Code') }}</label>
									<input type="text" class="form-control" name="billing_zip" id="billing_zip" required>
								</div>
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Country') }}</label>
									<select class="form-control form-select country-select" name="billing_country" id="billing_country"
									        data-type="billing" required>
										<option value="">{{ __('default.Select Country') }}</option>
									</select>
								</div>
							</div>
							
							<!-- Copy Billing Info Button -->
							<div class="d-grid mb-4">
								<button type="button" class="btn btn-secondary" id="copy-billing-info">
									{{ __('default.Copy Billing Info to Shipping') }}
								</button>
							</div>
							
							<!-- Shipping Information -->
							<h3 class="mb-4">{{ __('default.Shipping Address') }}</h3>
							<div class="row g-3 mb-4">
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Name and Surname') }}</label>
									<input type="text" class="form-control" name="shipping_name" id="shipping_name" required>
								</div>
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Phone') }}</label>
									<input type="tel" class="form-control" name="shipping_phone" id="shipping_phone" required>
								</div>
								<div class="col-12">
									<label class="form-label">{{ __('default.Address') }}</label>
									<input type="text" class="form-control" name="shipping_address" id="shipping_address" required>
								</div>
								
								<!-- Shipping Address City Section -->
								<div class="col-md-6 shipping-location-dropdowns">
									<label class="form-label">{{ __('default.City') }}</label>
									<!-- Dropdown fields for Turkey -->
									<select class="form-control city-select" id="shipping_city_select" name="shipping_city_select"
									        data-type="shipping" disabled>
										<option value="">{{ __('default.Select City') }}</option>
									</select>
								</div>
								<div class="col-md-6 shipping-location-dropdowns">
									<label class="form-label">{{ __('default.County') }}</label>
									<select class="form-control county-select" id="shipping_county_select" name="shipping_county_select"
									        data-type="shipping" disabled>
										<option value="">{{ __('default.Select County') }}</option>
									</select>
								</div>
								<div class="col-md-6 shipping-location-dropdowns">
									<label class="form-label">{{ __('default.District') }}</label>
									<select class="form-control district-select" id="shipping_district_select"
									        name="shipping_district_select" data-type="shipping"
									        disabled>
										<option value="">{{ __('default.Select District') }}</option>
									</select>
								</div>
								<div class="col-md-6 shipping-location-dropdowns">
									<label class="form-label">{{ __('default.Neighborhood') }}</label>
									<select class="form-control neighborhood-select" id="shipping_neighborhood_select"
									        name="shipping_neighborhood_select" data-type="shipping"
									        disabled>
										<option value="">{{ __('default.Select Neighborhood') }}</option>
									</select>
								</div>
								
								<div class="col-md-6 shipping-location-text">
									<label class="form-label">{{ __('default.City') }}</label>
									<input type="text" class="form-control" name="shipping_city" id="shipping_city">
								</div>
								
								<div class="col-md-6">
									<label class="form-label">{{ __('default.ZIP Code') }}</label>
									<input type="text" class="form-control" name="shipping_zip" id="shipping_zip" required>
								</div>
								
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Country') }}</label>
									<select class="form-control form-select country-select" name="shipping_country" id="shipping_country"
									        data-type="shipping" required>
										<option value="">{{ __('default.Select Country') }}</option>
									</select>
								</div>
							</div>
							
							<h3 class="mt-4 mb-4">{{ __('default.Payment Information') }}</h3>
							<div class="row g-3">
								<div class="col-md-6">
									<label class="form-label">{{ __('default.Card Number') }}</label>
									<input type="text" class="form-control" name="card_number" id="card_number" required>
								</div>
								<div class="col-md-3">
									<label class="form-label">{{ __('default.Expiry Date') }}</label>
									<input type="text" class="form-control" name="card_expiry" id="card_expiry" placeholder="MM/YY"
									       required>
								</div>
								<div class="col-md-3">
									<label class="form-label">{{ __('default.CVV') }}</label>
									<input type="text" class="form-control" name="card_cvv" id="card_cvv" required>
								</div>
							</div>
							
							<div class="mt-4">
								<button type="submit" class="btn btn-primary btn-lg w-100">
									{{ __('default.Place Order') }}
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="col-md-4">
				<div class="card shadow-sm">
					<div class="card-body">
						<h3 class="mb-4">{{ __('default.Order Summary') }}</h3>
						
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
								<span>{{ __('default.Print Size') }}:</span>
								<span>{{ $print_size === 'print_13_19_5_cm' ? '13 x 19.5 cm' : '16 x 20 cm' }}</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('default.checkout.copies') }} ({{ $quantity * 4 }}):</span>
								<span>{{1000 * $quantity}}</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('default.base_product') }}:</span>
								<span>{{__('default.checkout.currency_prefix')}}{{ number_format($base_price, 2) }}{{__('default.checkout.currency_suffix')}}</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('default.Subtotal') }}:</span>
								<span>{{__('default.checkout.currency_prefix')}}{{ number_format($subtotal, 2) }}{{__('default.checkout.currency_suffix')}}</span>
							</div>
							
							<div class="d-flex justify-content-between mb-2">
								<span>{{ __('default.Shipping') }}:</span>
								<span>{{ $shipping > 0 ? __('default.checkout.currency_prefix') . number_format($shipping, 2) . __('default.checkout.currency_suffix') : __('default.free_shipping') }}</span>
							</div>
							
							<hr>
							
							<div class="d-flex justify-content-between mb-2 fw-bold">
								<span>{{ __('default.Total') }}:</span>
								<span>{{__('default.checkout.currency_prefix')}}{{ number_format($total, 2) }}{{__('default.checkout.currency_suffix')}}</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	@include('layouts.footer')
	
	
	<style>
      .form-control {
          background-color: rgba(0, 0, 0, 0.1);
          border: 1px solid rgba(255, 255, 255, 1);
          color: inherit;
      }

      .form-control:focus {
          background-color: transparent;
          border-color: #dc6832;
          box-shadow: none;
          color: inherit;
      }

      [data-bs-theme=dark] .form-control {
          background-color: rgba(0, 0, 0, 0.2) !important;
      }

      [data-bs-theme=dark] select option {
          background-color: rgba(0, 0, 0, 0.8) !important;
      }

      .btn-secondary {
          background-color: #6c757d;
          border: none;
      }

      .btn-secondary:hover {
          background-color: #5a6268;
      }

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

      .is-invalid {
          border-color: #dc3545 !important;
      }

      .invalid-feedback {
          display: block;
          width: 100%;
          margin-top: 0.25rem;
          font-size: 0.875em;
          color: #dc3545;
      }
	</style>
	
	@push('scripts')
		<script src="/js/jquery.mask.min.js"></script>
		
		<script>
			$(document).ready(function () {
				// Initialize country dropdowns
				loadCountries('billing', true);
				loadCountries('shipping', true);
				
				// Handle country change
				$(document).on('change', '.country-select', function () {
					const type = $(this).data('type'); // billing or shipping
					const countryId = $(this).val();
					handleCountryChange(countryId, type);
				});
				
				// Handle city change for Turkey
				$(document).on('change', '.city-select', function () {
					const type = $(this).data('type');
					const cityId = $(this).val();
					loadCounties(cityId, type);
				});
				
				// Handle county change for Turkey
				$(document).on('change', '.county-select', function () {
					const type = $(this).data('type');
					const countyId = $(this).val();
					loadDistricts(countyId, type);
				});
				
				// Handle district change for Turkey
				$(document).on('change', '.district-select', function () {
					const type = $(this).data('type');
					const districtId = $(this).val();
					loadNeighborhoods(districtId, type);
				});
				
				function loadCountries(type, initial = false) {
					$.ajax({
						url: '/api/countries',
						type: 'GET',
						success: function (response) {
							const select = $(`#${type}_country`);
							select.empty();
							select.append('<option value="">{{ __('default.Select Country')}}</option>');
							response.forEach(country => {
								select.append(`<option value="${country.id}">${country.name}</option>`);
							});
							if (initial) {
								select.val(1).trigger('change');
							}
						}
					});
				}
				
				function handleCountryChange(countryId, type) {
					console.log(type);
					if (countryId == 1) { // Turkey
						// Show dropdown fields
						$(`.${type}-location-dropdowns`).show();
						$(`.${type}-location-text`).hide();
						
						// Load cities
						loadCities(countryId, type);
					} else {
						// Show text input fields
						$(`.${type}-location-dropdowns`).hide();
						$(`.${type}-location-text`).show();
						
						// Clear and disable dropdowns
						$(`#${type}_city_select, #${type}_county_select, #${type}_district_select, #${type}_neighborhood_select`).empty().prop('disabled', true);
					}
				}
				
				function loadCities(countryId, type) {
					$.ajax({
						url: `/api/cities/${countryId}`,
						type: 'GET',
						success: function (response) {
							const select = $(`#${type}_city_select`);
							select.empty().prop('disabled', false);
							select.append('<option value="">{{ __('default.Select City')}}</option>');
							response.forEach(city => {
								select.append(`<option value="${city.id}">${city.name}</option>`);
							});
						}
					});
				}
				
				function loadCounties(cityId, type) {
					$.ajax({
						url: `/api/counties/${cityId}`,
						type: 'GET',
						success: function (response) {
							const select = $(`#${type}_county_select`);
							select.empty().prop('disabled', false);
							select.append('<option value="">{{ __('default.Select County')}}</option>');
							response.forEach(county => {
								select.append(`<option value="${county.id}">${county.name}</option>`);
							});
						}
					});
				}
				
				function loadDistricts(countyId, type) {
					$.ajax({
						url: `/api/districts/${countyId}`,
						type: 'GET',
						success: function (response) {
							const select = $(`#${type}_district_select`);
							select.empty().prop('disabled', false);
							select.append('<option value="">{{ __('default.Select District')}}</option>');
							response.forEach(district => {
								select.append(`<option value="${district.id}">${district.name}</option>`);
							});
						}
					});
				}
				
				function loadNeighborhoods(districtId, type) {
					$.ajax({
						url: `/api/neighborhoods/${districtId}`,
						type: 'GET',
						success: function (response) {
							const select = $(`#${type}_neighborhood_select`);
							select.empty().prop('disabled', false);
							select.append('<option value="">{{ __('default.Select Neighborhood')}}</option>');
							response.forEach(neighborhood => {
								select.append(`<option value="${neighborhood.id}">${neighborhood.name}</option>`);
							});
						}
					});
				}
				
				// Copy billing info functionality
				$('#copy-billing-info').click(function () {
					$('#shipping_name').val($('#billing_name').val());
					$('#shipping_phone').val($('#billing_phone').val());
					$('#shipping_address').val($('#billing_address').val());
					
					const billingCountryId = $('#billing_country').val();
					$('#shipping_country').val(billingCountryId).trigger('change');
					
					if (billingCountryId == 1) {
						// Copy dropdown values
						setTimeout(() => {
							$('#shipping_city_select').val($('#billing_city_select').val()).trigger('change');
							setTimeout(() => {
								$('#shipping_county_select').val($('#billing_county_select').val()).trigger('change');
								setTimeout(() => {
									$('#shipping_district_select').val($('#billing_district_select').val()).trigger('change');
									setTimeout(() => {
										$('#shipping_neighborhood_select').val($('#billing_neighborhood_select').val());
									}, 500);
								}, 500);
							}, 500);
						}, 500);
					} else {
						$('#shipping_city').val($('#billing_city').val());
					}
					
					$('#shipping_zip').val($('#billing_zip').val());
				});
				
				// Add input masks
				$('#billing_zip, #shipping_zip').mask('00000');
				$('#card_number').mask('0000000000000000');
				$('#card_cvv').mask('000');
				$('#card_expiry').mask('00/00', {
					placeholder: "MM/YY"
				});
				
				// Validate card expiry
				function isValidExpiryDate(value) {
					if (!value.match(/^(0[1-9]|1[0-2])\/([0-9]{2})$/)) {
						return false;
					}
					
					const [month, year] = value.split('/');
					const expiry = new Date(2000 + parseInt(year), parseInt(month) - 1);
					const today = new Date();
					today.setDate(1);
					today.setHours(0, 0, 0, 0);
					
					return expiry >= today;
				}
				
				$('#checkout-form').on('submit', function (e) {
					e.preventDefault();
					
					// Reset previous error states
					$('.is-invalid').removeClass('is-invalid');
					$('.invalid-feedback').remove();
					
					let hasError = false;
					
					// Validate zip codes
					['billing_zip', 'shipping_zip'].forEach(function (field) {
						const value = $(`#${field}`).val();
						if (!/^\d+$/.test(value)) {
							$(`#${field}`).addClass('is-invalid');
							$(`#${field}`).after(`<div class="invalid-feedback">${field.includes('billing') ? 'Billing' : 'Shipping'} {{__('default.ZIP code must contain only numbers')}}</div>`);
							hasError = true;
						}
					});
					
					// Validate card number
					const cardNumber = $('#card_number').val().replace(/\D/g, '');
					if (cardNumber.length < 15 || cardNumber.length > 16) {
						$('#card_number').addClass('is-invalid');
						$('#card_number').after('<div class="invalid-feedback">{{__('default.Card number must be 15 or 16 digits')}}</div>');
						hasError = true;
					}
					
					// Validate CVV
					const cvv = $('#card_cvv').val();
					if (!/^\d{3}$/.test(cvv)) {
						$('#card_cvv').addClass('is-invalid');
						$('#card_cvv').after('<div class="invalid-feedback">{{__('default.CVV must be 3 digits')}}</div>');
						hasError = true;
					}
					
					// Validate expiry date
					const expiry = $('#card_expiry').val();
					if (!isValidExpiryDate(expiry)) {
						$('#card_expiry').addClass('is-invalid');
						$('#card_expiry').after('<div class="invalid-feedback">{{__('default.Invalid expiry date or card has expired')}}</div>');
						hasError = true;
					}
					
					if (!hasError) {
						
						$.ajax({
							url: '{{ route("checkout.process") }}',
							method: 'POST',
							data: $(this).serialize(),
							success: function (response) {
								if (response.success) {
									window.location.href = response.redirect;
								} else {
									alert(response.message);
								}
							},
							error: function (xhr) {
								if (xhr.status === 422) {
									const response = xhr.responseJSON;
									let errorMessage = '';
									
									// Join all errors with line breaks
									if (response.errors) {
										errorMessage = response.errors.join('\n');
									}
									
									// Display errors (adjust this according to your frontend setup)
									alert(errorMessage);
									// or
									$('#error-container').html(errorMessage.replace(/\n/g, '<br>'));
								}
							}
						});
					}
				});
			});
		</script>
	@endpush
@endsection
