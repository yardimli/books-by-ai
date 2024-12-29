@extends('layouts.app')

@section('content')
	<main>
		<div class="container" style="min-height: calc(88vh);">
			
			@if(session('success'))
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					{{ session('success') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif
			
			@if(session('error'))
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					{{ session('error') }}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			@endif
			
			
			<div class="row mt-3">
				<div class="col-12">
					<div class="d-flex justify-content-between align-items-center mb-4">
						<h5>{{ __('default.Books') }}</h5>
						<a href="{{ route('create-book') }}" class="btn btn-primary">
							{{ __('default.Create New Book') }}
						</a>
					</div>
					
					<!-- Articles List -->
					<div class="card">
						<div class="card-body">
							@if($books === [])
								<p class="text-center my-3">{{ __('default.No books found') }}</p>
							@else
								<div class="table-responsive">
									<table class="table table-hover">
										<thead>
										<tr>
											<th>{{ __('default.Title') }}</th>
											<th>{{ __('default.Language') }}</th>
											<th>{{ __('default.Status') }}</th>
											<th>{{ __('default.Created At') }}</th>
											<th>{{ __('default.Actions') }}</th>
										</tr>
										</thead>
										<tbody>
										@foreach($books as $book)
											<tr>
												<td>{{ Str::limit($book['book_title'], 50) }}</td>
												<td>{{ Str::limit($book['author_name'], 50) }}</td>
												<td>
                        <span
	                        class="badge bg-{{ $book['is_published'] ? 'success' : 'warning' }}">
                            {{ $book['is_published'] ? __('default.Published') : __('default.Draft') }}
                        </span>
												</td>
												<td>{{ $book['created_at'] }}</td>
												<td>
													<a href="{{ route('create-book', ['kitap_kodu' => $book['book_guid'], 'adim' => 7]) }}"
													   class="btn btn-sm btn-primary">
														{{ __('default.Purchase') }}
													</a>
													<a href="{{ route('create-book', ['kitap_kodu' => $book['book_guid']]) }}"
													   class="btn btn-sm btn-info">
														{{ __('default.Edit') }}
													</a>
													<form action="{{ route('delete-book', $book['book_guid']) }}"
													      method="POST"
													      class="d-inline"
													      onsubmit="return confirm('{{ __('default.Are you sure you want to delete this book?') }}')">
														@csrf
														@method('DELETE')
														<button type="submit" class="btn btn-sm btn-danger">
															{{ __('default.Delete') }}
														</button>
													</form>
												
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
@endsection
