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
			Schema::table('orders', function (Blueprint $table) {
				$table->string('id_number')->nullable()->after('billing_name');
				$table->string('billing_county')->nullable()->after('billing_city');
				$table->string('billing_district')->nullable()->after('billing_county');
				$table->string('billing_neighborhood')->nullable()->after('billing_district');
				$table->string('shipping_county')->nullable()->after('shipping_city');
				$table->string('shipping_district')->nullable()->after('shipping_county');
				$table->string('shipping_neighborhood')->nullable()->after('shipping_district');

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
