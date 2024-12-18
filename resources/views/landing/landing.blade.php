@extends('layouts.app')

@section('title', 'About')

@section('content')
	<link rel="stylesheet" href="/css/flickity.css" media="screen">
	<script src="/js/flickity.pkgd.min.js"></script>
	<style>
      .serif-font {
          font-family: Georgia, Times, "Times New Roman", serif;
      }

      @media (max-width: 767.98px) {
          /* Add padding to prevent content from being hidden behind fixed button */
          main {
              padding-bottom: 80px;
          }

          .mobile-cta {
              box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
          }

          .mobile-cta .btn-lg {
              width: 90%;
              max-width: 300px;
          }
      }
	</style>
	
	
	<main>
		@include('components.hero')
		@include('components.testimonials')
		@include('components.how-it-works')
		@include('components.cover-options')
		@include('components.faq')
		
		<div class="d-md-none fixed-bottom p-3 bg-light text-center mobile-cta">
			<a href="{{route('create-book')}}" class="btn btn-primary btn-lg px-5">{{ __('default.hero.cta') }}</a>
		</div>
	
	</main>
	<!-- **************** MAIN CONTENT END **************** -->
	
	
	@include('layouts.footer')

@endsection

@push('scripts')
	<!-- Inline JavaScript code -->
	<script>
		var current_page = 'my.landing';
		$(document).ready(function () {
		});
	</script>

@endpush
