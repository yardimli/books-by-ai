<?php

	namespace App\Http\Controllers;

	use App\Helpers\MyHelper;
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

		public function createBook(Request $request)
		{
			return view('landing.create-book')->with('step', $request->get('step', 1));
		}

		public function loadCover($style = 1)
		{
			return view('landing.cover' . $style);
		}

		public function loadSpine($style = 1)
		{
			return view('landing.spine' . $style);
		}

		public function loadBack($style = 1)
		{
			return view('landing.back' . $style);
		}

		function suggestBookTitleAndShortDescription(Request $request)
		{
			$user_prompt = $request->input('user_answers', 'A fantasy picture of a cat');
			if ($user_prompt === null || $user_prompt === '') {
				$user_prompt = 'A fantasy picture of a cat';
			}

			$gpt_prompt = "Suggest a title and a short description for a book that should not be taken seriously. It will be a full book with 200 pages. But the content will be satirical and humorous. The books language will be in Turkish. The book's title should be 2-3 words long, write 4 short reviews each consisting of 5 sentences with their sources. Try to include the author's name and book's title in the short reviews.
			
			The author has answered the following questions, use that as inspiration:
			
			Author Name: ".$request->input('author_name', 'Ali') . "
			
			".$user_prompt . "
			
			return 3 suggestions in the following JSON format: 
			" .
				'
{
    "suggestions": [
        {
				"title":"Yaratıcılığın Komik Halleri",
				"subtitle":"Bir Tasarımcının Absürt Günlüğü",
        "short_description" : "Yaratıcı süreçlerin absürt yanlarını, ilham perisinin kaprisleri ve tasarımcı bloğunun trajikomik yönlerini anlatan eğlenceli bir kitap.",
        "short_review_1":"Yaratıcı sürecin tüm çılgınlığını muhteşem bir şekilde yansıtmış. Her sayfada kendimi buldum ve kahkaha attım. Mutlaka okunması gereken bir eser.",
				"short_review_1_source": "- Sanat ve Tasarım Dergisi",
				"short_review_2": "İlham perisinin kaprislerini bu kadar güzel anlatan başka bir kitap görmedim. Yazarın mizah anlayışı muhteşem. Her yaratıcı insanın okuması gereken bir kitap.",
				"short_review_2_source": "- Kreatif Düşünce Platformu",
				"short_review_3": "Hem eğlenceli hem de gerçekçi bir kitap. Yaratıcı sürecin tüm zorluklarını mizahi bir dille anlatmış. Kesinlikle tavsiye ediyorum.",
				"short_review_3_source":"- Tasarım ve Sanat Blogu",
				"short_review_4":"Bu kitap tam bir terapi gibi. Her sayfada kendimi buldum ve rahatladım. Yaratıcı blokajı olan herkese şiddetle tavsiye ederim.",
				"short_review_4_source":"- Sanatçılar Birliği"
        },
        {
            "title": "",
            "subtitle": "",
            "short_description": ""
            "short_review_1": "",
            "short_review_1_source": "",
            "short_review_2": "",
            "short_review_2_source": "",
            "short_review_3": "",
            "short_review_3_source": ""
            "short_review_4": "",
            "short_review_4_source": ""
        },
        {
            "title": "",
            "subtitle": "",
            "short_description": ""
            "short_review_1": "",
            "short_review_1_source": "",
            "short_review_2": "",
            "short_review_2_source": "",
            "short_review_3": "",
            "short_review_3_source": ""
            "short_review_4": "",
            "short_review_4_source": ""
        }
    ]
}
';

			$chat_history[] = [
				'role' => 'user',
				'content' => $gpt_prompt,
			];

			$llm = 'anthropic/claude-3.5-sonnet:beta';

			$book_suggestions = MyHelper::llm_no_tool_call($llm, '', $chat_history, true);
			Log::info('Book Suggestions');
			Log::info($gpt_prompt);
			Log::info($book_suggestions);

			return response()->json($book_suggestions);
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
