<!-- components/faq.blade.php -->
<section class="py-5">
	<div class="container">
		<h2 class="text-center mb-4">{{ __('default.faq.title') }}</h2>
		<div class="accordion" id="faqAccordion">
			@foreach(__('default.faq.items') as $index => $faq)
				<div class="accordion-item">
					<h3 class="accordion-header">
						<button class="accordion-button collapsed" type="button"
						        data-bs-toggle="collapse"
						        data-bs-target="#faq{{ $index + 1 }}"
						        aria-expanded="false"
						        aria-controls="faq{{ $index + 1 }}">
							{{ $faq['question'] }}
						</button>
					</h3>
					<div id="faq{{ $index + 1 }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
						<div class="accordion-body">
							{{ $faq['answer'] }}
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<style>
    .accordion-item {
        border: 1px solid rgba(0,0,0,.125);
        margin-bottom: 0.5rem;
    }
    .accordion-button {
        font-weight: 500;
        padding: 1rem 1.25rem;
    }
    .accordion-button:not(.collapsed) {
        color: #0d6efd;
        background-color: rgba(13,110,253,.1);
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .accordion-body {
        padding: 1rem 1.25rem;
        line-height: 1.6;
    }
</style>
