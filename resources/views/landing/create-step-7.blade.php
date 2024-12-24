<div class="card shadow-sm">
	<div class="card-body p-4">
		<div class="mb-4">
			<div class="back-button p-0">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
					      stroke-linejoin="round"/>
				</svg>
			</div>
		</div>
		
		<div class="step-6-book-container" href="#">
			<div class="step-6-book">
				<img src="{{ $book->book_cover_image }}" id="previewFrontCover"/>
			</div>
		</div>
		
		<div class="text-center mt-4">
			@php
				$bookOptions = json_decode($book->book_options, true);
				$selectedOption = $bookOptions[$book->selected_book_option] ?? null;
			@endphp
			<div class="fs-4 book-title inria-serif-bold">{{ $selectedOption['title'] ?? '' }}</div>
			<div class="book-author-name inria-serif-regular fs-5">{{ $book->author_name }}
				- {{__('default.checkout.page_count')}}</div>
			
			<div class="alert alert-info mt-3 mb-5 inria-serif-regular">
				{{ __('default.checkout.page_count_description') }}
			</div>
		
		</div>
		
		<div class="mt-5">
			<!-- Book Format Selection -->
			<div class="d-flex gap-3 mb-4">
				<div
					class="format-option flex-grow-1 p-4 rounded-3 text-center {{ $selectedFormat === 'print_13_19_5_cm' ? 'selected' : '' }}"
					data-format="print_13_19_5_cm" data-price="{{__('default.checkout.normal_cover_size_price')}}">
					<div class="fs-5 inria-serif-regular">{{__('default.checkout.normal_cover_size')}}</div>
					<div class="inria-serif-bold price">{{__('default.checkout.currency_prefix')}}{{__('default.checkout.normal_cover_size_price')}}{{__('default.checkout.currency_suffix')}}</div>
				</div>
				<div
					class="format-option flex-grow-1 p-4 rounded-3 text-center {{ $selectedFormat === 'print_16_20_cm' ? 'selected' : '' }}"
					data-format="print_16_20_cm" data-price="{{__('default.checkout.large_cover_size_price')}}">
					<div class="fs-5 inria-serif-regular">{{__('default.checkout.large_cover_size')}}</div>
					<div class="price inria-serif-bold">{{__('default.checkout.currency_prefix')}}{{__('default.checkout.large_cover_size_price')}}{{__('default.checkout.currency_suffix')}}</div>
				</div>
			</div>
			
			<!-- Copies Selection -->
			<div class="d-flex justify-content-between mb-4">
				<div>
					<div class="fs-4 inria-serif-bold">{{ __('default.checkout.copies') }}</div>
					<div class="text-muted inria-serif-regular mt-2">{{ __('default.checkout.copies_description') }}</div>
				</div>
				<div class="copies-container d-flex align-items-center gap-3">
					<button class="copy-btn rounded-circle" data-action="decrease">-</button>
					<span id="copyCount" class="fs-5">1</span>
					<button class="copy-btn rounded-circle" data-action="increase">+</button>
				</div>
			</div>
			
			
			<!-- Shipping Options -->
			<div class="mb-4">
				<div class="fs-4 inria-serif-bold mb-2">{{ __('default.checkout.shipping') }}</div>
				<div class="shipping-option d-flex justify-content-between align-items-center p-3 mb-2 rounded-3">
					<div>
						<input type="radio" name="shipping" id="standard" checked>
						<label class="inria-serif-regular" for="standard">
							<strong>{{ __('default.checkout.standard_shipping') }}</strong><br>
							<span class="text-muted">{{ __('default.checkout.shipping_time') }}</span>
						</label>
					</div>
					<div>{{ __('default.checkout.free_shipping') }}</div>
				</div>
			</div>
			
			<!-- Order Summary -->
			<div class="summary mt-3">
				<div class="fs-4 inria-serif-bold mb-2">{{ __('default.checkout.summary') }}</div>
				<div class="d-flex justify-content-between mb-2">
					<div class="inria-serif-regular">{{ __('default.checkout.base_product') }}</div>
					<div class="inria-serif-regular">{{__('default.checkout.currency_prefix')}}{{ __('default.checkout.normal_cover_size_price') }}{{__('default.checkout.currency_suffix')}}</div>
				</div>
				<div class="d-flex justify-content-between mb-2">
					<div class="inria-serif-regular"><span id="additional_copies_label"></span>{{ __('default.checkout.additional_copies') }}</div>
					<div class="inria-serif-regular">{{__('default.checkout.currency_prefix')}}{{ __('default.checkout.additional_copies_price') }}{{__('default.checkout.currency_suffix')}}</div>
				</div>
				<div class="d-flex justify-content-between mb-3">
					<div class="inria-serif-regular">{{ __('default.checkout.shipping') }}</div>
					<div class="inria-serif-regular">{{ __('default.checkout.free_shipping') }}</div>
				</div>
				<div class="d-flex justify-content-between fw-bold">
					<div class="inria-serif-bold">{{ __('default.checkout.subtotal') }}</div>
					<div class="inria-serif-bold">{{__('default.checkout.currency_prefix')}}{{ __('default.checkout.normal_cover_size_price') }}{{__('default.checkout.currency_suffix')}}</div>
				</div>
			</div>
			
			<!-- Checkout Button -->
			<div class="d-grid gap-2 mt-4">
				<button class="btn btn-primary btn-lg checkout-btn">{{ __('default.checkout.checkout_button') }}</button>
			</div>
		</div>
	
	</div>
</div>

<style>
    .step-6-book-container {
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 600px;
        margin-top: 40px;
        margin-bottom: 60px;
    }

    @keyframes step-6-initAnimation {
        0% {
            transform: rotateY(0deg);
        }
        100% {
            transform: rotateY(-30deg);
        }
    }

    .step-6-book {
        width: 200px;
        height: 300px;
        position: relative;
        transform-style: preserve-3d;
        transform: rotateY(-30deg);
        transition: 1s ease;
        animation: 1s ease 0s 1 initAnimation;
    }

    .step-6-book:hover {
        transform: rotateY(0deg);
    }

    .step-6-book > :first-child {
        position: absolute;
        top: 0;
        left: 0;
        background-color: red;
        width: 200px;
        height: 300px;
        transform: translateZ(25px);
        background-color: #01060f;
        border-radius: 0 2px 2px 0;
        box-shadow: 5px 5px 20px #666;
    }

    .step-6-book::before {
        position: absolute;
        content: ' ';
        background-color: blue;
        left: 0;
        top: 3px;
        width: 48px;
        height: 294px;
        transform: translateX(172px) rotateY(90deg);
        background: linear-gradient(90deg,
        #fff 0%,
        #f9f9f9 5%,
        #fff 10%,
        #f9f9f9 15%,
        #fff 20%,
        #f9f9f9 25%,
        #fff 30%,
        #f9f9f9 35%,
        #fff 40%,
        #f9f9f9 45%,
        #fff 50%,
        #f9f9f9 55%,
        #fff 60%,
        #f9f9f9 65%,
        #fff 70%,
        #f9f9f9 75%,
        #fff 80%,
        #f9f9f9 85%,
        #fff 90%,
        #f9f9f9 95%,
        #fff 100%
        );
    }

    .step-6-book::after {
        position: absolute;
        top: 0;
        left: 0;
        content: ' ';
        width: 200px;
        height: 300px;
        transform: translateZ(-25px);
        background-color: #888;
        border-radius: 0 2px 2px 0;
        box-shadow: -10px 0 50px 10px #666;
    }

    .book-title {
        color: #333;
    }

    .book-author-name {
        color: #333;
    }

    .format-option {
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .format-option.selected {
        border-color: #dc6832;
        background-color: rgba(220, 104, 50, 0.1);
    }

    .copies-container .copy-btn {
        width: 30px;
        height: 30px;
        border: 2px solid #333;
        background: none;
        color: #fff;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .copies-container .copy-btn:hover {
        background-color: #333;
    }

    #copyCount {
        min-width: 30px;
        text-align: center;
    }

    .shipping-option {
        border: 1px solid rgba(255, 255, 255, 0.1);
        cursor: pointer;
    }

    .shipping-option:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .checkout-btn {
        background-color: #dc6832;
        border: none;
    }

    .checkout-btn:hover {
        background-color: #c55a2a;
    }

    .promo-code input {
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    [data-bs-theme=dark] .book-title {
        color: #ddd;
    }

    [data-bs-theme=dark] .book-author-name {
        color: #ddd;
    }

</style>

@push('scripts')
	<script>
		
		$(document).ready(function () {
			let copyCount = 1;
			let basePrice = {{__('default.checkout.normal_cover_size_price')}};
			let additionalCopyPrice = {{__('default.checkout.additional_copies_price')}};
			let shippingPrice = 0;
			
			$("#additional_copies_label").text(copyCount + 'x ');
			
			// Format selection
			$('.format-option').click(function () {
				$('.format-option').removeClass('selected');
				$(this).addClass('selected');
				basePrice = parseFloat($(this).data('price'));
				updateTotal();
			});
			
			// Copy count buttons
			$('.copy-btn').click(function () {
				const action = $(this).data('action');
				if (action === 'decrease' && copyCount > 0) {
					copyCount--;
				} else if (action === 'increase') {
					copyCount++;
				}
				$('#copyCount').text(copyCount);
				$("#additional_copies_label").text(copyCount + 'x ');
				updateTotal();
			});
			
			// Shipping selection
			$('input[name="shipping"]').change(function () {
				shippingPrice = $(this).attr('id') === 'expedited' ? 500 : 0;
				updateTotal();
			});
			
			function updateTotal() {
				const total = basePrice + (copyCount * additionalCopyPrice) + shippingPrice;
				$('.summary .fw-bold div:last-child').text('{{__('default.checkout.currency_prefix')}}' + total.toFixed(0) + '{{__('default.checkout.currency_suffix')}}');
			}
			
			updateTotal();
			
			$('.checkout-btn').click(function () {
				// Handle checkout process
				alert('Proceeding to checkout...');
			});
		});
	</script>
@endpush
