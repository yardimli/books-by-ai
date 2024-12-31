@extends('layouts.app')

@section('title', __('default.Order Success'))

@section('content')
	<div class="container py-5 mt-5">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card shadow-sm mb-4">
					<div class="card-body text-center">
						<div class="mb-4">
							<i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
						</div>
						<h2 class="mb-4">{{ __('default.order_success_message') }}</h2>
						<p class="text-muted">{{ __('default.order_number') }}: {{ $order->order_number }}</p>
					</div>
				</div>
				
				<!-- Order Details -->
				<div class="card shadow-sm mb-4">
					<div class="card-header">
						<h3 class="mb-0">{{ __('default.Order Details') }}</h3>
					</div>
					<div class="card-body">
						<div class="row mb-4">
							<div class="col-md-6">
								<h4>{{ __('default.Billing Address') }}</h4>
								<p>
									{{ $order->billing_name }}<br>
									{{ $order->billing_address }}<br>
									@if($order->billing_country == 1)
										@php
											$billingCity = \Epigra\TrGeoZones\Models\City::find($order->billing_city);
											$billingCounty = \Epigra\TrGeoZones\Models\County::find($order->billing_county);
											$billingDistrict = \Epigra\TrGeoZones\Models\District::find($order->billing_district);
											$billingNeighborhood = \Epigra\TrGeoZones\Models\Neighbourhood::find($order->billing_neighborhood);
										@endphp
										{{ $billingNeighborhood->name ?? '' }}, {{ $billingDistrict->name ?? '' }}<br>
										{{ $billingCounty->name ?? '' }}, {{ $billingCity->name ?? '' }}<br>
									@else
										{{ $order->billing_city }}<br>
									@endif
									{{ $order->billing_zip }}<br>
									{{ __('default.countries.' . $order->billing_country) }}
								</p>
							</div>
							<div class="col-md-6">
								<h4>{{ __('default.Shipping Address') }}</h4>
								<p>
									{{ $order->shipping_name }}<br>
									{{ $order->shipping_address }}<br>
									@if($order->shipping_country == 1)
										@php
											$shippingCity = \Epigra\TrGeoZones\Models\City::find($order->shipping_city);
											$shippingCounty = \Epigra\TrGeoZones\Models\County::find($order->shipping_county);
											$shippingDistrict = \Epigra\TrGeoZones\Models\District::find($order->shipping_district);
											$shippingNeighborhood = \Epigra\TrGeoZones\Models\Neighbourhood::find($order->shipping_neighborhood);
										@endphp
										{{ $shippingNeighborhood->name ?? '' }}, {{ $shippingDistrict->name ?? '' }}<br>
										{{ $shippingCounty->name ?? '' }}, {{ $shippingCity->name ?? '' }}<br>
									@else
										{{ $order->shipping_city }}<br>
									@endif
									{{ $order->shipping_zip }}<br>
									{{ __('default.countries.' . $order->shipping_country) }}
								</p>
							</div>
						</div>
						
						<!-- Order Items -->
						<h4 class="mb-3">{{ __('default.Order Items') }}</h4>
						<div class="table-responsive">
							<table class="table">
								<thead>
								<tr>
									<th>{{ __('default.Item') }}</th>
									<th>{{ __('default.Print Size') }}</th>
									<th>{{ __('default.Quantity') }}</th>
									<th class="text-end">{{ __('default.Price') }}</th>
									<th class="text-end">{{ __('default.Subtotal') }}</th>
								</tr>
								</thead>
								<tbody>
								@foreach($order->items as $item)
									<tr>
										<td>
											@php
												$book = \App\Models\Book::where('book_guid', $item->book_guid)->first();
												$bookOptions = json_decode($book->book_options ?? '[]', true);
												$selectedOption = $bookOptions[$book->selected_book_option ?? 0] ?? null;
											@endphp
											{{ $selectedOption['title'] ?? 'Book Title' }}
										</td>
										<td>{{ $item->print_size === 'print_13_19_5_cm' ? '13 x 19.5 cm' : '16 x 20 cm' }}</td>
										<td>{{ $item->quantity }}</td>
										<td class="text-end">{{ number_format($item->price, 2) }} ₺</td>
										<td class="text-end">{{ number_format($item->subtotal, 2) }} ₺</td>
									</tr>
								@endforeach
								</tbody>
								<tfoot>
								<tr>
									<td colspan="4" class="text-end">{{ __('default.Subtotal') }}:</td>
									<td class="text-end">{{ number_format($order->subtotal, 2) }} ₺</td>
								</tr>
								<tr>
									<td colspan="4" class="text-end">{{ __('default.Shipping') }}:</td>
									<td
										class="text-end">{{ $order->shipping > 0 ? number_format($order->shipping, 2) . ' ₺' : __('default.free_shipping') }}</td>
								</tr>
								<tr>
									<td colspan="4" class="text-end"><strong>{{ __('default.Total') }}:</strong></td>
									<td class="text-end"><strong>{{ number_format($order->total, 2) }} ₺</strong></td>
								</tr>
								</tfoot>
							</table>
						</div>
						
						<!-- Shipping Information -->
						<div class="mt-4">
							<h4>{{ __('default.Shipping Information') }}</h4>
							<p>{{ __('default.shipping_info_message') }}</p>
							<div class="alert alert-info">
								{{ __('default.estimated_delivery_message') }}
							</div>
						</div>
					</div>
				</div>
				
				<!-- Actions -->
				<div class="d-grid gap-2">
					<a href="{{ route('my-books') }}" class="btn btn-primary">
						{{ __('default.back_to_my_books') }}
					</a>
				</div>
			</div>
		</div>
	</div>
	
	<style>
      .card {
          border: none;
          border-radius: 10px;
      }

      [data-bs-theme=dark] .card {
          background-color: #2b3035;
      }

      .text-success {
          color: #28a745 !important;
      }

      .table {
          margin-bottom: 0;
      }

      .alert {
          border-radius: 10px;
      }
	</style>
@endsection
