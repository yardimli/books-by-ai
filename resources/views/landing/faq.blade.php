<section class="py-5" style="background: linear-gradient(175deg, #ffffff 0%, #f8f9fa 15%);"> {{-- Reversed gradient --}}
	<div class="container" style="max-width: 800px;"> {{-- Limit width for readability --}}
		<h2 class="text-center mb-4 fw-bold">{{ __('default.faq.title') }}</h2>
		<div class="accordion accordion-flush" id="faqAccordion"> {{-- Use accordion-flush for borderless look --}}
			@foreach(__('default.faq.items') as $index => $faq)
				<div class="accordion-item funky-accordion-item">
					<h3 class="accordion-header" id="faqHeading{{ $index + 1 }}">
						<button class="accordion-button collapsed funky-accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index + 1 }}" aria-expanded="false" aria-controls="faqCollapse{{ $index + 1 }}">
							{{ $faq['question'] }}
						</button>
					</h3>
					<div id="faqCollapse{{ $index + 1 }}" class="accordion-collapse collapse" aria-labelledby="faqHeading{{ $index + 1 }}" data-bs-parent="#faqAccordion">
						<div class="accordion-body funky-accordion-body">
							{{ $faq['answer'] }}
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
</section>

<style>
    .funky-accordion-item {
        background-color: #fff; /* White background for item */
        border: 1px solid #e0e0e0; /* Softer border */
        border-radius: 10px; /* Rounded corners */
        margin-bottom: 1rem; /* Space between items */
        box-shadow: 0 2px 5px rgba(0,0,0,0.05); /* Subtle shadow */
        overflow: hidden; /* Ensure radius applies correctly */
    }

    .funky-accordion-button {
        font-weight: 600; /* Bolder question */
        padding: 1.25rem 1.5rem; /* More padding */
        color: #343a40; /* Darker text */
        background-color: #fff; /* Ensure white background */
        border-radius: 10px; /* Match item radius */
        width: 100%; /* Ensure full width */
        text-align: left;
    }

    .funky-accordion-button:not(.collapsed) {
        color: var(--bs-primary); /* Primary color when open */
        background-color: #f8f9fa; /* Light background when open */
        box-shadow: none; /* Remove default focus shadow */
        border-bottom: 1px solid #e0e0e0; /* Separator line */
        border-radius: 10px 10px 0 0; /* Adjust radius when open */
    }

    .funky-accordion-button:focus {
        box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25); /* Custom focus */
        border-color: transparent; /* Hide border on focus */
        z-index: 3;
    }

    /* Custom Icons */
    .funky-accordion-button::after {
        flex-shrink: 0;
        width: 1.5rem; /* Icon size */
        height: 1.5rem; /* Icon size */
        margin-left: auto;
        content: "";
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%236c757d'%3e%3cpath fill-rule='evenodd' d='M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/%3e%3cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3e%3c/svg%3e"); /* Plus Circle Icon (grey) */
        background-repeat: no-repeat;
        background-size: 1.5rem;
        transition: transform 0.2s ease-in-out;
    }

    .funky-accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%230d6efd'%3e%3cpath fill-rule='evenodd' d='M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/%3e%3cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3e%3c/svg%3e"); /* Minus Circle Icon (primary color) */
        transform: rotate(0deg); /* No rotation needed for minus */
    }

    .funky-accordion-body {
        padding: 1.25rem 1.5rem; /* Match button padding */
        line-height: 1.7; /* More line spacing */
        background-color: #fff; /* Ensure white background */
        border-radius: 0 0 10px 10px; /* Match item radius */
    }
</style>
