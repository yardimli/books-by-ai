<?php

	use App\Http\Controllers\ArticleController;
	use App\Http\Controllers\BookController;
	use App\Http\Controllers\CategoryController;
	use App\Http\Controllers\ChatController;
	use App\Http\Controllers\CheckoutController;
	use App\Http\Controllers\ImageController;
	use App\Http\Controllers\LanguageController;
	use App\Http\Controllers\LoginWithGoogleController;
	use App\Http\Controllers\StaticPagesController;
	use App\Http\Controllers\UserSettingsController;
	use App\Http\Controllers\VerifyThankYouController;
	use App\Mail\WelcomeMail;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Mail;
	use Illuminate\Support\Facades\Route;


	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register web routes for your application. These
	| routes are loaded by the RouteServiceProvider and all of them will
	| be assigned to the "web" middleware group. Make something great!
	|
	*/

	//-------------------------------------------------------------------------
	Route::get('/', [StaticPagesController::class, 'landing'])->name('landing-page');

	Route::get('/kitap-yaz', [BookController::class, 'createBook'])->name('create-book');
	Route::post('/kitap-guncelle', [BookController::class, 'updateBook'])->name('update-book');


	Route::post('/kitap-sakla', [BookController::class, 'saveBook'])->name('save-book');
	Route::post('/kitap-oneri', [BookController::class, 'suggestBookTitleAndShortDescription'])->name('suggest-book-title-and-short-description');
	Route::post('/yazar-foto-yukle', [BookController::class, 'uploadAuthorImage'])->name('upload-author-image');
	Route::post('/kitap-icindekiler', [BookController::class, 'createBookTOC'])->name('create-book-toc');

	Route::post('/zemin-sil', [BookController::class, 'removeBg'])->name('remove-bg');
	Route::post('/zemin-sil2', [BookController::class, 'removeBg2'])->name('remove-bg2');

	Route::get('/kapak-yukle/{style?}', [BookController::class, 'loadCover'])->name('load-cover');
	Route::get('/sirt-yukle/{style?}', [BookController::class, 'loadSpine'])->name('load-spine');
	Route::get('/arka-yukle/{style?}', [BookController::class, 'loadBack'])->name('load-back');

	Route::get('/lang/home', [LanguageController::class, 'index']);
	Route::get('/lang/change', [LanguageController::class, 'change'])->name('changeLang');

	Route::get('login/google', [LoginWithGoogleController::class, 'redirectToGoogle']);
	Route::get('login/google/callback', [LoginWithGoogleController::class, 'handleGoogleCallback']);

	Route::get('/logout', [LoginWithGoogleController::class, 'logout']);

	Route::get('/verify-thank-you', [VerifyThankYouController::class, 'index'])->name('verify-thank-you')->middleware('verified');
	Route::get('/verify-thank-you-zh_TW', [VerifyThankYouController::class, 'index_zh_TW'])->name('verify-thank-you-zh_TW')->middleware('verified');

	Route::get('/privacy', [StaticPagesController::class, 'privacy'])->name('privacy-page');
	Route::get('/terms', [StaticPagesController::class, 'terms'])->name('terms-page');
	Route::get('/help', [StaticPagesController::class, 'help'])->name('help-page');
	Route::get('/help/{topic}', [StaticPagesController::class, 'helpDetails'])->name('help-details');
	Route::get('/about', [StaticPagesController::class, 'about'])->name('about-page');
	Route::get('/contact', [StaticPagesController::class, 'contact'])->name('contact-page');
	Route::get('/onboarding', [StaticPagesController::class, 'onboarding'])->name('onboarding-page');
	Route::get('/change-log', [StaticPagesController::class, 'changeLog'])->name('change-log-page');
	Route::get('/help', [StaticPagesController::class, 'help'])->name('help-page');

	// web.php

	Route::match(['get', 'post'], '/checkout', [CheckoutController::class, 'index'])->name('checkout');
	Route::get('/checkout/{book_guid}', [CheckoutController::class, 'index'])->name('checkout.show');

	//-------------------------------------------------------------------------
	Route::middleware(['auth'])->group(function () {


		Route::get('/kitaplarim', [BookController::class, 'myBooks'])->name('my-books');
		Route::delete('/kitap-sil/{book_guid}', [BookController::class, 'destroy'])->name('delete-book');

		Route::post('/alisveris/islem', [CheckoutController::class, 'process'])->name('checkout.process');
		Route::get('/alisveris/basarili/{order}', [CheckoutController::class, 'success'])->name('order.success');

		Route::get('/siparisler', [CheckoutController::class, 'orders'])->name('orders.index');
		Route::get('/siparisler/{orderNumber}', [CheckoutController::class, 'orderDetails'])->name('orders.details');


		Route::post('/settings', [UserSettingsController::class, 'updateSettings'])->name('settings-update');

		Route::get('/settings/account', [UserSettingsController::class, 'account'])->name('settings.account');
		Route::post('/settings/password', [UserSettingsController::class, 'updatePassword'])->name('settings-password-update');
		Route::post('/settings/password', [UserSettingsController::class, 'updatePassword'])->name('settings-password-update');
		Route::get('/settings/close-account', [UserSettingsController::class, 'closeAccount'])->name('settings.close-account');

		//------------------------------------------------------------------------- ADMIN
		Route::get('/check-llms-json', [ChatController::class, 'checkLLMsJson']);

		Route::get('/chat/sessions', [ChatController::class, 'getChatSessions']);
		Route::get('/chat/{session_id?}', [ChatController::class, 'index'])->name('chat');
		Route::post('/create-session', [ChatController::class, 'createSession'])->name('chat.create-session');
		Route::get('/chat/messages/{sessionId}', [ChatController::class, 'getChatMessages']);
		Route::post('/send-llm-prompt', [ChatController::class, 'sendLlmPrompt'])->name('send-llm-prompt');
		Route::delete('/chat/{sessionId}', [ChatController::class, 'destroy'])->name('chat.destroy');

		Route::get('/settings/languages', [UserSettingsController::class, 'languages'])->name('settings.languages');
		Route::get('/settings/categories', [UserSettingsController::class, 'categories'])->name('settings.categories');
		Route::get('/settings/images', [UserSettingsController::class, 'images'])->name('settings.images');

		Route::post('/settings/api-keys', [UserSettingsController::class, 'updateApiKeys'])->name('settings-update-api-keys');

		Route::get('/users', [UserSettingsController::class, 'admin_index'])->name('admin-index');
		Route::post('/login-as', [UserSettingsController::class, 'loginAs'])->name('users-login-as');

		Route::resource('articles', ArticleController::class);

		// Language Management Routes
		Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
		Route::post('/languages', [LanguageController::class, 'store'])->name('languages.store');
		Route::get('/languages/{language}/edit', [LanguageController::class, 'edit'])->name('languages.edit');
		Route::put('/languages/{language}', [LanguageController::class, 'update'])->name('languages.update');
		Route::delete('/languages/{language}', [LanguageController::class, 'destroy'])->name('languages.destroy');

		// Category Management Routes
		Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
		Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
		Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
		Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
		Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

		Route::get('/upload-images', [ImageController::class, 'index'])->name('upload-images.index');
		Route::post('/upload-images', [ImageController::class, 'store'])->name('upload-images.store');
		Route::put('/upload-images/{id}', [ImageController::class, 'update'])->name('upload-images.update');
		Route::delete('/upload-images/{id}', [ImageController::class, 'destroy'])->name('upload-images.destroy');

		Route::get('/image-gen/sessions', [ImageController::class, 'getImageGenSessions'])->name('image-gen-sessions');
		Route::post('/image-gen', [ImageController::class, 'makeImage'])->name('send-image-gen-prompt');
		Route::delete('/image-gen/{session_id}', [ImageController::class, 'destroyGenImage'])->name('image-gen.destroy');


		Route::prefix('articles')->group(function () {
			Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
			Route::get('/create', [ArticleController::class, 'create'])->name('articles.create');
			Route::post('/', [ArticleController::class, 'store'])->name('articles.store');
			Route::get('/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
			Route::put('/{article}', [ArticleController::class, 'update'])->name('articles.update');
			Route::delete('/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
			Route::get('/get-images', [ArticleController::class, 'getImages'])->name('articles.get-images');
		});
	});

	//-------------------------------------------------------------------------

	Auth::routes();
	Auth::routes(['verify' => true]);
