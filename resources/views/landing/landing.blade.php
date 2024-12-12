@extends('layouts.app')

@section('title', 'About')

@section('content')
	<link rel="stylesheet" href="/css/flickity.css" media="screen">
	<script src="/js/flickity.pkgd.min.js"></script>
	<style>
      .serif-font {
          font-family: Georgia, Times, "Times New Roman", serif;
      }
	</style>
	
	
	<main>
		@include('components.hero')
		@include('components.testimonials')
		@include('components.how-it-works')
		@include('components.cover-options')
		@include('components.faq')
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
