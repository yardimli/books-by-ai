<?php

	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class Order extends Model
	{
		protected $fillable = [
			'user_id', 'order_number', 'subtotal', 'shipping', 'total',
			'status', 'billing_name', 'id_number', 'billing_email', 'billing_phone',
			'billing_address', 'billing_city',
			'billing_county', 'billing_district', 'billing_neighborhood',
			'billing_zip', 'billing_country', 'shipping_name',
			'shipping_email', 'shipping_phone', 'shipping_address',
			'shipping_city',
			'shipping_county', 'shipping_district', 'shipping_neighborhood',
			'shipping_zip',
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
