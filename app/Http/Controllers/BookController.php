<?php

	namespace App\Http\Controllers;

	use App\Helpers\MyHelper;
	use App\Models\Book;
	use App\Models\Image;
	use CURLFile;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Facades\Log;
	use Illuminate\Support\Facades\Storage;
	use Illuminate\Support\Str;


	class BookController extends Controller
	{

		public function myBooks(Request $request)
		{
			$book_data = Book::where('user_id', Auth::id())->get();
			$books = [];
			foreach ($book_data as $book) {
				$book_options = json_decode($book->book_options, true);
				$selected_option = $book_options[$book->selected_book_option] ?? null;
				$book_title = $selected_option['title'] ?? 'Adsız Kitap';
				$book_subtitle = $selected_option['subtitle'] ?? 'Adsız Alt Başlık';
				$book_description = $selected_option['short_description'] ?? 'Adsız bir kitap açıklaması.';

				$books[] = [
					'id' => $book->id,
					'is_published' => $book->is_published,
					'book_guid' => $book->book_guid,
					'author_name' => $book->author_name,
					'book_title' => $book_title,
					'book_subtitle' => $book_subtitle,
					'book_description' => $book_description,
					'created_at' => $book->created_at->format('Y-m-d H:i:s'),
					'updated_at' => $book->updated_at->format('Y-m-d H:i:s'),
				];
			}


			return view('user.my-books')->with('books', $books);
		}

		public function destroy($book_guid)
		{
			if (!Auth::check()) {
				return redirect()->route('login');
			}
			try {
				$book = Book::where('book_guid', $book_guid)
					->where('user_id', Auth::id())
					->firstOrFail();
				$book->delete();

				// Redirect with success message
				return redirect()->back()->with('success', __('default.Book deleted successfully'));

			} catch (\Exception $e) {
				// Redirect with error message if something goes wrong
				return redirect()->back()->with('error', __('default.Failed to delete book'));
			}
		}

		public function createBook(Request $request)
		{
			$step = $request->get('adim', 1);
			$book_guid = $request->get('kitap_kodu', '');

			if (empty($book_guid)) {
				// Create new book record
				$book = new Book();
				$book->book_guid = (string)Str::uuid();
				$book->user_id = Auth::id() ?? 0;
				$book->save();

				if (!Auth::check()) {
					session(['temp_book_guid' => $book->book_guid]);
				}

				// Redirect with the new book_guid
				return redirect()->route('create-book', ['adim' => 1, 'kitap_kodu' => $book->book_guid]);
			}

			// Load existing book data
			$book = Book::where('book_guid', $book_guid)->first();
			// if book not found, redirect to create new book
			if (!$book) {
				return redirect()->route('create-book');
			}

			//if user hasnt logged in, and session has no temp_book_guid, assign temp_book_guid to session
			if (!Auth::check() && !session()->has('temp_book_guid')) {
				session(['temp_book_guid' => $book_guid]);
			}

			// Validate current step and redirect if needed
			$validationResult = $this->validateStep($step, $book);
			if (!$validationResult['valid']) {
				return redirect()->route('create-book', [
					'adim' => $validationResult['redirect_step'],
					'kitap_kodu' => $book->book_guid
				])->with('error', $validationResult['message']);
			}

			return view('create-book.create-book')
				->with('step', $step)
				->with('book', $book);
		}

		private function validateStep($currentStep, Book $book): array
		{
			$result = [
				'valid' => true,
				'redirect_step' => 1,
				'message' => ''
			];

			// Validate all previous steps
			for ($i = 1; $i < $currentStep; $i++) {
				switch ($i) {
					case 1:
						if (empty($book->author_name)) {
							return [
								'valid' => false,
								'redirect_step' => 1,
								'message' => __('default.create.step_errors.Please enter author name first')
							];
						}
						break;

					case 2:
						if (empty($book->questions_and_answers)) {
							return [
								'valid' => false,
								'redirect_step' => 2,
								'message' => __('default.create.step_errors.Please complete the questionnaire first')
							];
						}
						break;

					case 3:
						if (empty($book->book_options) || $book->selected_book_option < 0) {
							return [
								'valid' => false,
								'redirect_step' => 3,
								'message' => __('default.create.step_errors.Please select a book option first')
							];
						}
						break;

					case 4:
						if (empty($book->author_image)) {
							return [
								'valid' => false,
								'redirect_step' => 4,
								'message' => __('default.create.step_errors.Please upload an author image first')
							];
						}
						break;

					case 5:
						if (empty($book->selected_cover_template) || empty($book->book_cover_image)) {
							return [
								'valid' => false,
								'redirect_step' => 5,
								'message' => __('default.create.step_errors.Please select and generate a cover design first')
							];
						}
						break;

					case 6:
						if (empty($book->book_toc)) {
							return [
								'valid' => false,
								'redirect_step' => 6,
								'message' => __('default.create.step_errors.Please generate table of contents first')
							];
						}
						break;
				}
			}

			return $result;
		}

		public function updateBook(Request $request)
		{
			$book_guid = $request->input('book_guid');
			$book = Book::where('book_guid', $book_guid)->firstOrFail();

			// Update book data based on step
			switch ($request->input('step')) {
				case 1:
					$book->author_name = $request->input('author_name');
					break;
				case 2:
					$book->questions_and_answers = json_encode($request->input('answers'));
					break;
				case 3:
					if ($request->input('suggestions')) {
						$book->book_options = json_encode($request->input('suggestions'));
					}
					$book->selected_book_option = $request->input('selected_option') ?? 0;
					break;
				case 4:
					$book->author_image = $request->input('author_image');
					$book->author_image_no_bg = $request->input('author_image_no_bg');
					break;
				case 5:
					$book->selected_cover_template = $request->input('cover_style') ?? 1;
					break;
				case 51:
					$book->author_image_scale = $request->input('image_scale') ?? 1.0;
					$book->author_image_x_offset = $request->input('image_x_offset') ?? 0;
					$book->author_image_y_offset = $request->input('image_y_offset') ?? 0;
					break;
				case 52:
					$book->book_cover_image = $request->input('cover_image');
					$book->book_spine_image = $request->input('spine_image');
					$book->book_back_image = $request->input('back_image');

					// Create directory if it doesn't exist
					if (!Storage::disk('public')->exists('book-covers')) {
						Storage::disk('public')->makeDirectory('book-covers');
					}

					// Generate a unique filename using the book's GUID
					$timestamp = time();
					$coverFilename = "book-covers/{$book->book_guid}_front_{$timestamp}.png";
					$spineFilename = "book-covers/{$book->book_guid}_spine_{$timestamp}.png";
					$backFilename = "book-covers/{$book->book_guid}_back_{$timestamp}.png";

					try {
						// Save front cover
						if ($request->input('cover_image')) {
							$coverImage = $request->input('cover_image');
							$coverImage = str_replace('data:image/png;base64,', '', $coverImage);
							$coverImage = str_replace(' ', '+', $coverImage);
							$coverImageData = base64_decode($coverImage);
							Storage::disk('public')->put($coverFilename, $coverImageData);
						}

						// Save spine cover
						if ($request->input('spine_image')) {
							$spineImage = $request->input('spine_image');
							$spineImage = str_replace('data:image/png;base64,', '', $spineImage);
							$spineImage = str_replace(' ', '+', $spineImage);
							$spineImageData = base64_decode($spineImage);
							Storage::disk('public')->put($spineFilename, $spineImageData);
						}

						// Save back cover
						if ($request->input('back_image')) {
							$backImage = $request->input('back_image');
							$backImage = str_replace('data:image/png;base64,', '', $backImage);
							$backImage = str_replace(' ', '+', $backImage);
							$backImageData = base64_decode($backImage);
							Storage::disk('public')->put($backFilename, $backImageData);
						}

					} catch (\Exception $e) {
						Log::error('Error saving cover images: ' . $e->getMessage());
						return response()->json([
							'success' => false,
							'message' => 'Error saving cover images: ' . $e->getMessage()
						], 500);
					}

					break;
				case 6:
					$book->book_toc = json_encode($request->input('toc'));
					break;
			}

			$book->save();

			return response()->json([
				'success' => true,
				'book' => $book
			]);
		}


		public function loadCover($style = 1)
		{
			return view('create-book.cover' . $style);
		}

		public function loadSpine($style = 1)
		{
			return view('create-book.spine' . $style);
		}

		public function loadBack($style = 1)
		{
			return view('create-book.back' . $style);
		}

		function suggestBookTitleAndShortDescription(Request $request)
		{
			$user_answers = $request->input('user_answers', '[{"question": "What is the meaning of life?", "answer": "42"}, {"question": "What do you think about the universe?", "answer": "It is vast and mysterious"}]');

			$user_answers = json_decode($user_answers, true);
			// Format user answers as string
			$user_answers = implode("\n", array_map(function ($item) {
				return "Soru: " . $item['question'] . "\nCevap: " . $item['answer'] . "\n";
			}, $user_answers));


			$gpt_prompt = "Suggest a title and a short description for a book that should not be taken seriously. It will be a full book with 200 pages. But the content will be satirical and humorous. The books language will be in Turkish. The book's title should be 2-3 words long, write 4 short reviews each consisting of 3 sentences with their sources. Try to include the author's name and book's title in the short reviews.
			
The author has answered the following questions, use that as inspiration:

Author Name: " . $request->input('author_name', 'Ali') . "

" . $user_answers . "

return 3 suggestions in the following JSON format: 
" .
				'
{
  "suggestions": [
    {
			"title":"A Funny 2-3 word title",
			"subtitle":"10-15 word subtitle",
      "short_description" : "3-4 sentence description of the book",
      "reviews": [
        {
          "review": "first review focusing on the humor and satire in the book",
					"source": "- Source of the review"
				},
				{
					"review": "second review focusing on the readability and entertainment value of the book",
					"source": "- Source of the review"
				},
				{
					"review": "third review focusing on the author\'s writing style and creativity",
					"source": "- Source of the review"
				},
				{
					"review": "fourth review focusing on the book\'s impact on the reader and the author\'s unique perspective",
					"source": "- Source of the review"
				}
			]
		},
		{
      "title": "",
      "subtitle": "",
      "short_description": "",
      "reviews": [
        {
            "review": "",
						"source": ""
				},
				{
						"review": "",
						"source": ""
				},
				{
						"review": "",
						"source": ""
				},
				{
						"review": "",
						"source": ""
				}
			]
    },
    {
      "title": "",
      "subtitle": "",
      "short_description": ""
      "reviews": [
        {
          "review": "",
					"source": ""
				},
				{
					"review": "",
					"source": ""
				},
				{
					"review": "",
					"source": ""
				},
				{
					"review": "",
					"source": ""
				}
			]
    }
  ]
}
';

			$chat_history[] = [
				'role' => 'user',
				'content' => $gpt_prompt,
			];

			$llm = 'anthropic/claude-3.5-sonnet:beta';

//			$book_suggestions = MyHelper::llm_no_tool_call($llm, '', $chat_history, true);
			$book_suggestions = MyHelper::gemini_call('', $chat_history, true);
			Log::info('Book Suggestions');
			Log::info($gpt_prompt);
			Log::info($book_suggestions);

			return response()->json($book_suggestions);
		}


		function createBookTOC(Request $request)
		{
			$book_guid = $request->input('book_guid');
			$book = Book::where('book_guid', $book_guid)->firstOrFail();

			$book_author_name = $book->author_name;

			$user_answers = $book->questions_and_answers;

			$user_answers = json_decode($user_answers, true);
			// Format user answers as string
			$user_answers = implode("\n", array_map(function ($item) {
				return "Question: " . $item['question'] . "\nAnswer: " . $item['answer'] . "\n";
			}, $user_answers));

			$bookOptions = json_decode($book->book_options ?? '[]', true);
			$selectedOption = $bookOptions[$book->selected_book_option ?? 0] ?? null;

			$book_title = $selectedOption['title'] ?? 'Absürt Günlük';
			$book_subtitle = $selectedOption['subtitle'] ?? 'Bir Tasarımcının Absürt Günlüğü';
			$book_description = $selectedOption['short_description'] ?? 'Yaratıcı süreçlerin absürt yanlarını, ilham perisinin kaprisleri ve tasarımcı bloğunun trajikomik yönlerini anlatan eğlenceli bir kitap.';

			$book_structure = 'Write a table of contents for a book in ##language##. Use the following details to create the table of contents, pay attention to the author\'s answers, on some of the chapters use the author\'s name. The book content is a satirical and humorous. Avoid serious, controversial, and political topics and keep the tone light and fun. It should be a fun read.

Author Name: ##author_name##
Book Title: ##book_title##
Book Sub Title: ##book_subtitle##
Book Description: ##book_description##
Book Language: ##language##
Question and Answers: ##answers##
Number of chapters: 18

Create a story outline in the format "3 Act Structure" with the structure like

1. Perde - Başlangıç:
Bölüm 1: Ana karakterin sıradan hayatını ve komik alışkanlıklarını tanıtma
Bölüm 2: Günlük rutinini bozan beklenmedik komik bir olay
Bölüm 3: Bu olayın yarattığı absürt durumlar ve karakterin tepkileri
Bölüm 4: İşlerin daha da karışması ve karakterin çözüm arayışları

2. Perde - Orta:
Bölüm 5: Karakterin durumu düzeltme çabalarının ters tepmesi
Bölüm 6: Yeni ve daha komik sorunların ortaya çıkması
Bölüm 7: Yardım almak için başvurduğu kişilerin işleri daha da karıştırması
Bölüm 8: Absürt çözüm denemelerinin başarısızlıkla sonuçlanması
Bölüm 9: Beklenmedik bir şans, ama karakterin bunu yanlış anlaması
Bölüm 10: Yanlış anlamanın yol açtığı trajikomik durumlar
Bölüm 11: Her şeyi düzeltme fırsatının ortaya çıkması
Bölüm 12: Bu fırsatı değerlendirirken yapılan komik hatalar
Bölüm 13: İşlerin en karışık hale gelmesi
Bölüm 14: Çözüme yaklaşırken son bir büyük karışıklık

3. Perde - Son:
Bölüm 15: Tüm yanlış anlaşılmaların ortaya çıkması
Bölüm 16: Beklenmedik ve komik bir şekilde olayların çözülmeye başlaması
Bölüm 17: Son süprizler ve gülünç tesadüfler
Bölüm 18: Her şeyin absürt bir şekilde çözüme kavuşması ve mutlu son

Not: Her bölümde:
- Abartılı karakterler ve durumlar
- Komik diyaloglar
- Beklenmedik olaylar
- Günlük hayattan gülünç detaylar
- Absürt tesadüfler
kullanılarak hikaye ilerletilir.

Output should be in JSON format as follows:
{
"acts": [
{
"name": "The name of the act",
"chapters": [
{
"chapter_number":"number of the chapter",
"chapter_title": "The name of the chapter",
"chapter_short_description": "A detailed description of what happens in this chapter. it should be 3 to 4 sentences long.",
"events": "Notable events in the chapter.",
"people": "Description of people in the chapter.",
"places": "Description of the places in this chapter.",
}
]
}
]
}

Don\'t include any text in front or after the JSON object.

Use Double Quotes for Keys and String Values.
		Avoid Double Quotes Inside String Values. Instead, use Single Quotes.
		All opening double quotes should have a corresponding closing double quote.
		Output 4 chapters for the first act, 8 chapters for the second act, and 4 chapters for the third act.

		```json
';
			$book_structure = str_replace('##language##', 'Turkish', $book_structure);
			$book_structure = str_replace('##author_name##', $book_author_name, $book_structure);
			$book_structure = str_replace('##book_title##', $book_title, $book_structure);
			$book_structure = str_replace('##book_subtitle##', $book_subtitle, $book_structure);
			$book_structure = str_replace('##book_description##', $book_description, $book_structure);
			$book_structure = str_replace('##answers##', $user_answers, $book_structure);

			$chat_history[] = [
				'role' => 'user',
				'content' => $book_structure,
			];

			$llm = 'anthropic/claude-3.5-sonnet:beta';
			$llm = 'google/gemini-flash-1.5';
			$llm = 'google/gemini-2.0-flash-exp:free';

//			$book_toc = MyHelper::llm_no_tool_call($llm, '', $chat_history, true);
			$book_toc = MyHelper::gemini_call('', $chat_history, true);
			Log::info('Book Table of Contents');
			Log::info($book_structure);
			Log::info($book_toc);

			return response()->json($book_toc);
		}

		private function resizeImage($sourcePath, $destinationPath, $maxWidth)
		{
			// Suppress libpng warnings
			ini_set('gd.png.ignore_warning', 1);

			list($originalWidth, $originalHeight, $type) = getimagesize($sourcePath);

			// Calculate new dimensions
			$ratio = $originalWidth / $originalHeight;
			$newWidth = min($maxWidth, $originalWidth);
			$newHeight = $newWidth / $ratio;

			// Create new image
			$newImage = imagecreatetruecolor($newWidth, $newHeight);

			// Handle transparency for PNG images
			if ($type == IMAGETYPE_PNG) {
				// These settings help maintain transparency
				imagealphablending($newImage, false);
				imagesavealpha($newImage, true);
				$transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
				imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
			}

			// Load source image
			try {
				switch ($type) {
					case IMAGETYPE_JPEG:
						$source = @imagecreatefromjpeg($sourcePath);
						break;
					case IMAGETYPE_PNG:
						$source = @imagecreatefrompng($sourcePath);
						break;
					case IMAGETYPE_GIF:
						$source = @imagecreatefromgif($sourcePath);
						break;
					default:
						return false;
				}

				if (!$source) {
					return false;
				}

				// Resize
				imagecopyresampled(
					$newImage,
					$source,
					0, 0, 0, 0,
					$newWidth,
					$newHeight,
					$originalWidth,
					$originalHeight
				);

				// Save resized image
				switch ($type) {
					case IMAGETYPE_JPEG:
						imagejpeg($newImage, $destinationPath, 90);
						break;
					case IMAGETYPE_PNG:
						imagepng($newImage, $destinationPath, 9);
						break;
					case IMAGETYPE_GIF:
						imagegif($newImage, $destinationPath);
						break;
				}

				// Free up memory
				imagedestroy($newImage);
				imagedestroy($source);

				return true;
			} catch (\Exception $e) {
				if (isset($newImage)) {
					imagedestroy($newImage);
				}
				if (isset($source)) {
					imagedestroy($source);
				}
				return false;
			}
		}

		public function uploadAuthorImage(Request $request)
		{
			if ($request->hasFile('image')) {
				$file = $request->file('image');

				if (!Storage::disk('public')->exists('author-images')) {
					Storage::disk('public')->makeDirectory('author-images');
				}

				$path = $file->store('author-images', 'public');
				return response()->json([
					'url' => Storage::url($path),
					'path' => $path
				]);
			}
			return response()->json(['error' => 'No image uploaded'], 400);
		}

		public function removeBg(Request $request)
		{
			$model = 'https://queue.fal.run/fal-ai/imageutils/rembg';
			$falApiKey = $_ENV['FAL_API_KEY'];

			if (empty($falApiKey)) {
				return json_encode(['error' => 'FAL_API_KEY environment variable is not set']);
			}

			$client = new \GuzzleHttp\Client();

			// Initial request to queue the job
			$response = $client->post($model, [
				'headers' => [
					'Authorization' => 'Key ' . $falApiKey,
					'Content-Type' => 'application/json',
				],
				'json' => [
					'image_url' => $request->input('image_url'),
				]
			]);

			$initialData = json_decode($response->getBody(), true);
			Log::info('Initial FAL response:', $initialData);

			if (!isset($initialData['request_id'])) {
				return json_encode(['success' => false, 'message' => 'No request ID received']);
			}

			// Poll for results
			$maxAttempts = 10;
			$attempt = 0;
			$delay = 2; // seconds

			while ($attempt < $maxAttempts) {
				sleep($delay);

				try {
					$statusResponse = $client->get("https://queue.fal.run/fal-ai/imageutils/requests/{$initialData['request_id']}", [
						'headers' => [
							'Authorization' => 'Key ' . $falApiKey
						]
					]);

					$result = json_decode($statusResponse->getBody(), true);
					Log::info('Poll response:', $result);

					if (isset($result['image']['url'])) {
						// Process successful result
						$image_url = $result['image']['url'];
						$image = file_get_contents($image_url);

						if (!Storage::disk('public')->exists('author-images')) {
							Storage::disk('public')->makeDirectory('author-images');
						}

						// Create directories if they don't exist
						$directories = ['original', 'large', 'medium', 'small'];
						foreach ($directories as $dir) {
							if (!Storage::disk('public')->exists("author-images/$dir")) {
								Storage::disk('public')->makeDirectory("author-images/$dir");
							}
						}

						$guid = Str::uuid();
						$extension = 'png';

						// Generate filenames
						$originalFilename = $guid . '.' . $extension;

						$outputFile = Storage::disk('public')->path('author-images/original/' . $originalFilename);
						file_put_contents($outputFile, $image);

						// Create resized versions
						$this->resizeImage(
							$outputFile,
							storage_path('app/public/author-images/large/' . $originalFilename),
							1024
						);
						$this->resizeImage(
							$outputFile,
							storage_path('app/public/author-images/medium/' . $originalFilename),
							600
						);
						$this->resizeImage(
							$outputFile,
							storage_path('app/public/author-images/small/' . $originalFilename),
							300
						);

						return json_encode([
							'success' => true,
							'message' => __('Image generated successfully'),
							'image_filename' => $originalFilename,
							'data' => json_encode($result),
						]);
					}

					if (isset($result['status']) && $result['status'] === 'FAILED') {
						return json_encode([
							'success' => false,
							'message' => 'Processing failed',
							'error' => $result['error'] ?? 'Unknown error'
						]);
					}

				} catch (\Exception $e) {
					Log::error('Error polling FAL API: ' . $e->getMessage());
				}

				$attempt++;
			}

			return json_encode([
				'success' => false,
				'message' => 'Timeout waiting for image processing'
			]);
		}


		public function removeBg2(Request $request)
		{
			// Initialize cURL session
			$ch = curl_init();
			$filePath = storage_path('app/public/' . $request->input('path'));

			if (!file_exists($filePath)) {
				return json_encode([
					'success' => false,
					'file' => $filePath,
					'message' => 'File not found or not readable'
				]);
			}

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mimeType = finfo_file($finfo, $filePath);
			finfo_close($finfo);

			// Prepare the file
			$cfile = new CURLFile($filePath, $mimeType, 'image_file');

			// Setup cURL options

			curl_setopt($ch, CURLOPT_URL, 'https://api.remove.bg/v1.0/removebg');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, [
				'image_file' => $cfile,
				'size' => 'preview'
			]);
			curl_setopt($ch,
				CURLOPT_HTTPHEADER, [
					'X-Api-Key: ' . $_ENV['REMOVE_BG_KEY']
				]);
			// Add these SSL options
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

			// Execute the request
			$response = curl_exec($ch);
			$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$curlError = '';
			if (curl_errno($ch)) {
				$curlError = curl_error($ch);
			}

			// Close cURL session
			curl_close($ch);

			// If response is 200, save the image
			if ($httpCode == 200) {
				$guid = Str::uuid();
				$extension = 'png';
				$filename = $guid . '.' . $extension;
				$outputFile = Storage::disk('public')->path('author-images/original/' . $filename);

				// Save the image
				file_put_contents($outputFile, $response);

				// Create resized versions
				$this->resizeImage(
					$outputFile,
					storage_path('app/public/author-images/large/' . $filename),
					1024
				);
				$this->resizeImage(
					$outputFile,
					storage_path('app/public/author-images/medium/' . $filename),
					600
				);
				$this->resizeImage(
					$outputFile,
					storage_path('app/public/author-images/small/' . $filename),
					300
				);

				return json_encode([
					'success' => true,
					'message' => __('Image generated successfully'),
					'image_filename' => Storage::url('author-images/original/' . $filename)
				]);
			} else {
				// Try to decode error response
				$error = json_decode($response, true);

				return json_encode([
					'success' => false,
					'message' => 'Processing failed',
					'http_code' => $httpCode,
					'curl_error' => $curlError,
					'response' => $response,
					'error' => $error['errors'][0]['message'] ?? 'Unknown error'
				]);
			}
		}

	}
