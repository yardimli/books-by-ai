<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Order extends Model
	{
		protected $fillable = [
			'user_id', 'order_number', 'subtotal', 'shipping', 'total',
			'status', 'billing_name', 'billing_email', 'billing_phone',
			'billing_address', 'billing_city', 'billing_state',
			'billing_zip', 'billing_country', 'shipping_name',
			'shipping_email', 'shipping_phone', 'shipping_address',
			'shipping_city', 'shipping_state', 'shipping_zip',
			'shipping_country', 'payment_method', 'payment_status',
			'transaction_id'
		];

		public function items()
		{
			return $this->hasMany(OrderItem::class);
		}

		public function user()
		{
			return $this->belongsTo(User::class);
		}
	}
