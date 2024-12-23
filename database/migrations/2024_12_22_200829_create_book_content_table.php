<?php

	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	use Illuminate\Support\Facades\Schema;

	return new class extends Migration {
		/**
		 * Run the migrations.
		 */
		public function up(): void
		{
			Schema::create('books', function (Blueprint $table) {
				$table->id();
				$table->integer('user_id')->index()->default(0);
				$table->uuid('book_guid')->unique();
				$table->integer('book_language_id')->index()->default(0);
				$table->string('author_name', 100)->nullable();
				$table->longText('questions_and_answers')->nullable();
				$table->longText('book_options')->nullable();
				$table->integer('selected_book_option')->default(0);
				$table->string('author_image',255)->nullable();
				$table->string('author_image_no_bg',255)->nullable();
				$table->integer('selected_cover_template')->default(1);
				$table->double('author_image_scale', 8, 2)->default(1.0);
				$table->double('author_image_x_offset', 8, 2)->default(0.0);
				$table->double('author_image_y_offset', 8, 2)->default(0.0);
				$table->binary('book_cover_image')->nullable();
				$table->binary('book_spine_image')->nullable();
				$table->binary('book_back_image')->nullable();
				$table->longText('book_toc')->nullable();
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down(): void
		{
			Schema::dropIfExists('books');
		}
	};
