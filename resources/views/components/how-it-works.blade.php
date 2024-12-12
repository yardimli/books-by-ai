<section class="how-it-works py-5">
	<div class="container">
		<h2 class="text-center mb-2">{{ __('default.how_it_works.title') }}</h2>
		
		<!-- Step 1 -->
		<div class="row step-content-dynamic-margin">
			<div class="col-lg-6 d-flex align-items-center">
				<div class="step-content">
					<div class="step-number serif-font">{{ __('default.how_it_works.step1.number') }}</div>
					<h4 class="serif-font">{{ __('default.how_it_works.step1.heading') }}</h4>
					<p class="step-description serif-font">{{ __('default.how_it_works.step1.description') }}</p>
				</div>
			</div>
			<div class="col-lg-6 d-flex justify-content-center">
				<div class="question-card">
					<div class="profile-header">
						<div class="profile-img mb-2">
							<img src="/images/profile1.jpg" alt="Profile">
						</div>
						<h5 class="serif-font">{{ __('default.how_it_works.step1.profile_title') }}</h5>
					</div>
					<div class="question-form">
						<div class="question-item question-item-shadow">
							<div class="d-flex justify-content-between">
								<span class="serif-font fw-bold">{{ __('default.how_it_works.step1.hobby_question') }}</span>
								<i class="bi bi-chevron-up"></i>
							</div>
							<div class="answer-text serif-font">
								{{ __('default.how_it_works.step1.hobby_answer') }}
							</div>
							<button class="btn btn-dark w-100">{{ __('default.how_it_works.step1.save_button') }}</button>
						</div>
						<div class="question-item collapsed">
							<div class="d-flex justify-content-between">
								<span class=" serif-font">{{ __('default.how_it_works.step1.friends_question') }}</span>
								<i class="bi bi-chevron-down"></i>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Step 2 -->
		<div class="row step-content-dynamic-margin">
			<div class="col-lg-6 d-flex align-items-center">
				<div class="step-content">
					<div class="step-number serif-font">{{ __('default.how_it_works.step2.number') }}</div>
					<h4 class="serif-font">{{ __('default.how_it_works.step2.heading') }}</h4>
					<p class="step-description serif-font">{{ __('default.how_it_works.step2.description') }}</p>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="book-covers-grid text-center">
					<img src="/images/book1.jpg" alt="Book Cover" class="img-fluid book-cover-image">
					<img src="/images/book2.jpg" alt="Book Cover" class="img-fluid book-cover-image">
					<br>
					<img src="/images/book3.jpg" alt="Book Cover" class="img-fluid book-cover-image">
					<img src="/images/book4.jpg" alt="Book Cover" class="img-fluid book-cover-image">
				</div>
			</div>
		</div>
		
		<!-- Step 3 -->
		<div class="row step-content-dynamic-margin">
			<div class="col-lg-6 d-flex align-items-center">
				<div class="step-content">
					<div class="step-number serif-font">{{ __('default.how_it_works.step3.number') }}</div>
					<h4 class="serif-font">{{ __('default.how_it_works.step3.heading') }}</h4>
					<p class="step-description serif-font">{{ __('default.how_it_works.step3.description') }}</p>
				</div>
			</div>
			<div class="col-lg-6 text-center">
				<div class="book-preview">
					<img src="/images/open-book.webp" alt="Open Book" class="img-fluid rounded">
				</div>
			</div>
		</div>
	</div>
</section>

<style>
    .container {
        max-width: 800px;
    }

    .how-it-works {
        color: #000;
    }

    .book-cover-image {
        max-width: 120px;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .step-number {
        padding-bottom: 5px;
        color: rgb(227, 111, 61, 1);
        background-color: rgba(227, 111, 61, .1);
        display: flex;
        width: 40px;
        height: 40px;
        font-size: 25px; /* Adjust font-size if necessary */
        border-radius: 50%;
        justify-content: center; /* Horizontally centers the content */
        align-items: center; /* Vertically centers the content */
        margin-bottom: 1rem;
    }

    [data-bs-theme=dark] .step-number {
        color: #ff6b6b;
        background-color: #222222;
    }

    .step-content h3 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .step-content-dynamic-margin {
        margin-bottom: 50px;
        margin-top: 50px;
    }

    .step-description {
        color: #a0a0a0;
        font-size: 16px;
        line-height: 1.6;
    }

    .question-card {
        background-color: #fff1e6;
        border-radius: 10px;
        padding: 10px;
        color: #1c1c1c !important;
        max-width: 300px;
    }

    .question-item-shadow {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .question-item.collapsed {
        background-color: #fffee6;
    }

    .profile-header {
        margin-bottom: 10px;
        text-align: center;
    }

    .answer-text {
        border: 1px solid #e0e0e0;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .profile-header h5 {
        color: #1c1c1c !important;
        font-size: 18px;
    }

    .profile-img img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
    }

    .question-item {
        background-color: #ffffff;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .book-covers-grid img {
        transition: transform 0.3s ease;
    }

    .book-covers-grid img:hover {
        transform: scale(1.05);
    }

    .book-preview img {
        max-width: 300px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {

        .step-number {
		        margin-left: auto;
		        margin-right: auto;
        }
        .step-content {
            text-align: center;
            margin-bottom: 5px;
		        margin-top:15px;
        }

        .question-card {
            margin-bottom: 10px;
        }

        .step-content-dynamic-margin {
            margin-bottom: 15px;
            margin-top: 15px;
        }

    }
</style>
