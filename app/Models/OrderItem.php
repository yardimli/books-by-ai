<?php
	namespace App\Models;

	use Illuminate\Database\Eloquent\Model;

	class OrderItem extends Model
	{
		protected $fillable = [
			'order_id', 'book_guid', 'quantity', 'print_size',
			'price', 'subtotal'
		];

		public function order()
		{
			return $this->belongsTo(Order::class);
		}
	}
