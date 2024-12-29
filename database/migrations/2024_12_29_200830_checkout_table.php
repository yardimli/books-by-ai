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
			Schema::create('orders', function (Blueprint $table) {
				$table->id();
				$table->foreignId('user_id')->constrained();
				$table->string('order_number')->unique();
				$table->decimal('subtotal', 10, 2);
				$table->decimal('shipping', 10, 2);
				$table->decimal('total', 10, 2);
				$table->string('status')->default('pending');

				// Billing Address
				$table->string('billing_name');
				$table->string('billing_email');
				$table->string('billing_phone');
				$table->string('billing_address');
				$table->string('billing_city');
				$table->string('billing_state');
				$table->string('billing_zip');
				$table->string('billing_country');

				// Shipping Address
				$table->string('shipping_name');
				$table->string('shipping_email');
				$table->string('shipping_phone');
				$table->string('shipping_address');
				$table->string('shipping_city');
				$table->string('shipping_state');
				$table->string('shipping_zip');
				$table->string('shipping_country');

				// Payment
				$table->string('payment_method');
				$table->string('payment_status');
				$table->string('transaction_id')->nullable();

				$table->timestamps();
			});

			Schema::create('order_items', function (Blueprint $table) {
				$table->id();
				$table->foreignId('order_id')->constrained()->onDelete('cascade');
				$table->string('book_guid');
				$table->integer('quantity');
				$table->string('print_size');
				$table->decimal('price', 10, 2);
				$table->decimal('subtotal', 10, 2);
				$table->timestamps();
			});
		}

		/**
		 * Reverse the migrations.
		 */
		public function down(): void
		{
			Schema::dropIfExists('order_items');
			Schema::dropIfExists('orders');
		}
	};
