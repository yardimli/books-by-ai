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
			Schema::table('books', function (Blueprint $table) {
				$table->integer('is_published')->default(0)->after('book_language_id');
			});

		}

		/**
		 * Reverse the migrations.
		 */
		public function down(): void
		{
			Schema::table('books', function (Blueprint $table) {
				$table->dropColumn('is_published');
			});
		}
	};
