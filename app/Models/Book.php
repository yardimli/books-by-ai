<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\BelongsTo;
	use Illuminate\Database\Eloquent\Relations\BelongsToMany;
	use Illuminate\Support\Str;

	class Book extends Model
	{
		protected $fillable = [
			'user_id',
			'book_guid',
			'book_language_id',
			'is_published',
			'author_name',
			'questions_and_answers',
			'book_options',
			'selected_book_option',
			'author_image',
			'author_image_no_bg',
			'selected_cover_template',
			'author_image_scale',
			'author_image_x_offset',
			'author_image_y_offset',
			'book_cover_image',
			'book_spine_image',
			'book_back_image',
			'book_toc'
		];

		public function user(): BelongsTo
		{
			return $this->belongsTo(User::class);
		}
	}
