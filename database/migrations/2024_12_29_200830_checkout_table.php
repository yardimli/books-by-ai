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
				$table->string('billing_name')->nullable();
				$table->string('billing_phone')->nullable();
				$table->string('billing_address')->nullable();
				$table->string('billing_city')->nullable();
				$table->string('billing_state')->nullable();
				$table->string('billing_zip')->nullable();
				$table->string('billing_country')->nullable();

				// Shipping Address
				$table->string('shipping_name')->nullable();
				$table->string('shipping_phone')->nullable();
				$table->string('shipping_address')->nullable();
				$table->string('shipping_city')->nullable();
				$table->string('shipping_state')->nullable();
				$table->string('shipping_zip')->nullable();
				$table->string('shipping_country')->nullable();

				// Payment
				$table->string('payment_method')->nullable();
				$table->string('payment_status')->nullable();
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
