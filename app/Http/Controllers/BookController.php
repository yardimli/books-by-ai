<?php

	namespace App\Http\Controllers;

	use App\Helpers\MyHelper;
	use App\Models\Image;
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

			$gpt_prompt = "Suggest a title and a short description for a book that should not be taken seriously. It will be a full book with 200 pages. But the content will be satirical and humorous. The books language will be in Turkish.
			
			The author has answered the following questions, use that as inspiration:" .
				$user_prompt . "
			
			return 3 suggestions in the following JSON format: 
			" .
				'
{
    "suggestions": [
        {
            "title": "The Cat Who Ate The Moon",
            "short_description": "A cat who eats the moon and goes on a journey to find it again."
        },
        {
            "title": "The Cat Who Ate The Moon",
            "short_description": "A cat who eats the moon and goes on a journey to find it again."
        },
        {
            "title": "The Cat Who Ate The Moon",
            "short_description": "A cat who eats the moon and goes on a journey to find it again."
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
			list($originalWidth, $originalHeight, $type) = getimagesize($sourcePath);

			// Calculate new dimensions
			$ratio = $originalWidth / $originalHeight;
			$newWidth = min($maxWidth, $originalWidth);
			$newHeight = $newWidth / $ratio;

			// Create new image
			$newImage = imagecreatetruecolor($newWidth, $newHeight);

			// Handle transparency for PNG images
			if ($type == IMAGETYPE_PNG) {
				imagealphablending($newImage, false);
				imagesavealpha($newImage, true);
				$transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
				imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
			}

			// Load source image
			switch ($type) {
				case IMAGETYPE_JPEG:
					$source = imagecreatefromjpeg($sourcePath);
					break;
				case IMAGETYPE_PNG:
					$source = imagecreatefrompng($sourcePath);
					break;
				case IMAGETYPE_GIF:
					$source = imagecreatefromgif($sourcePath);
					break;
				default:
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
					'url' => Storage::url($path)
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
						$largeFilename = $guid . '_large.' . $extension;
						$mediumFilename = $guid . '_medium.' . $extension;
						$smallFilename = $guid . '_small.' . $extension;

						$outputFile = Storage::disk('public')->path('author-images/original/' . $originalFilename);
						file_put_contents($outputFile, $image);

						// Create resized versions
						$this->resizeImage(
							$outputFile,
							storage_path('app/public/author-images/large/' . $largeFilename),
							1024
						);
						$this->resizeImage(
							$outputFile,
							storage_path('app/public/author-images/medium/' . $mediumFilename),
							600
						);
						$this->resizeImage(
							$outputFile,
							storage_path('app/public/author-images/small/' . $smallFilename),
							300
						);

						return json_encode([
							'success' => true,
							'message' => __('Image generated successfully'),
							'image_large_filename' => $largeFilename,
							'image_medium_filename' => $mediumFilename,
							'image_small_filename' => $smallFilename,
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
			$client = new GuzzleHttp\Client();
			$res = $client->post('https://api.remove.bg/v1.0/removebg', [
				'multipart' => [
					[
						'name'     => 'image_file',
						'contents' => fopen('/path/to/file.jpg', 'r')
					],
					[
						'name'     => 'size',
						'contents' => 'auto'
					]
				],
				'headers' => [
					'X-Api-Key' => 'INSERT_YOUR_API_KEY_HERE'
				]
			]);

			$fp = fopen("no-bg.png", "wb");
			fwrite($fp, $res->getBody());
			fclose($fp);
		}
		//zsDLK4dtznBvzXQmNLkkMmkb

	}
