@extends('layouts.app')
@section('title', __('default.My Orders'))
@section('content')
	<div class="container py-5 mt-5">
		<h2 class="mb-4">{{ __('default.My Orders') }}</h2>
		<div class="card shadow-sm">
			<div class="table-responsive">
				<table class="table">
					<thead>
					<tr>
						<th>{{ __('default.Order Number') }}</th>
						<th>{{ __('default.Book Title') }}</th>
						<th>{{ __('default.Date') }}</th>
						<th>{{ __('default.Total') }}</th>
						<th>{{ __('default.Status') }}</th>
						<th>{{ __('default.Actions') }}</th>
					</tr>
					</thead>
					<tbody>
					@forelse($orders as $order)
						<tr>
							<td>{{ $order->order_number }}</td>
							<td>
								@foreach($order->items as $item)
									@php
										$book = \App\Models\Book::where('book_guid', $item->book_guid)->first();
										$bookOptions = json_decode($book->book_options ?? '[]', true);
										$selectedOption = $bookOptions[$book->selected_book_option ?? 0] ?? null;
									@endphp
									{{ $selectedOption['title'] ?? 'Book Title' }}
									@break
									@if(!$loop->last)
										,
									@endif
								@endforeach
							</td>
							<td>{{ $order->created_at->format('d/m/Y') }}</td>
							<td>{{__('default.checkout.currency_prefix')}}{{ number_format($order->total, 2) }}{{__('default.checkout.currency_suffix')}}</td>
							<td>
              <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : 'success' }}">
                  {{ ucfirst($order->status) }}
              </span>
							</td>
							<td>
								<a href="{{ route('orders.details', $order->order_number) }}" class="btn btn-sm btn-primary">
									{{ __('default.View Details') }}
								</a>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="text-center">
								{{ __('default.No orders found') }}
							</td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	@include('layouts.footer')
	
	<style>
      .card {
          border: none;
          border-radius: 10px;
      }

      [data-bs-theme=dark] .card {
          background-color: #2b3035;
      }

      .table th {
          border-top: none;
      }

      .badge {
          padding: 0.5em 0.75em;
      }
	</style>
@endsection
