<?php

	namespace App\Http\Controllers;

	use App\Models\Book;
	use App\Models\Order;
	use App\Models\OrderItem;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Str;
	use Illuminate\Support\Facades\DB;

	class CheckoutController extends Controller
	{
		// CheckoutController.php

		public function index(Request $request)
		{
			$book_guid = $request->input('book_guid') ?? 'null';
			$quantity = $request->input('quantity', 1);
			$print_size = $request->input('print_size', 'print_13_19_5_cm');

			if (!Auth::check()) {
				session(['temp_book_guid' => $book_guid]);
				return response()->json(['redirect' => route('register')]);
			}

			$book = Book::where([
				'book_guid' => $book_guid,
				'user_id' => Auth::id()
			])->first();

			if ($book) {
				// Calculate prices based on print size
				$base_price = $print_size === 'print_13_19_5_cm' ? 1600 : 2000;
				$subtotal = $base_price + (1000 * $quantity);
				$shipping = 0; // Free shipping
				$total = $subtotal + $shipping;

				return view('checkout.index', compact(
					'book',
					'quantity',
					'print_size',
					'base_price',
					'subtotal',
					'shipping',
					'total'
				));
			}

			return redirect()->route('my-books');
		}

		public function process(Request $request)
		{
			// Validate request
			$request->validate([
				'billing_name' => 'required',
				'billing_email' => 'required|email',
				'billing_phone' => 'required',
				'billing_address' => 'required',
				'billing_city' => 'required',
				'billing_state' => 'required',
				'billing_zip' => 'required',
				'billing_country' => 'required',
				'shipping_name' => 'required',
				'shipping_email' => 'required|email',
				'shipping_phone' => 'required',
				'shipping_address' => 'required',
				'shipping_city' => 'required',
				'shipping_state' => 'required',
				'shipping_zip' => 'required',
				'shipping_country' => 'required',
				'card_number' => 'required',
				'card_expiry' => 'required',
				'card_cvv' => 'required',
			]);

			try {
				DB::beginTransaction();

				// Process payment (dummy implementation)
				$payment_success = $this->processDummyPayment($request);

				if (!$payment_success) {
					return response()->json([
						'success' => false,
						'message' => 'Payment failed. Please try again.'
					]);
				}

				// Create order
				$order = Order::create([
					'user_id' => auth()->id(),
					'order_number' => 'ORD-' . strtoupper(Str::random(10)),
					'subtotal' => $request->input('subtotal'),
					'shipping' => $request->input('shipping'),
					'total' => $request->input('total'),
					'status' => 'pending',
					'billing_name' => $request->input('billing_name'),
					'billing_email' => $request->input('billing_email'),
					// ... fill in other fields ...
					'payment_method' => 'credit_card',
					'payment_status' => 'paid',
					'transaction_id' => 'TXN-' . strtoupper(Str::random(10))
				]);

				// Create order item
				OrderItem::create([
					'order_id' => $order->id,
					'book_guid' => $request->input('book_guid'),
					'quantity' => $request->input('quantity'),
					'print_size' => $request->input('print_size'),
					'price' => $request->input('price'),
					'subtotal' => $request->input('subtotal')
				]);

				DB::commit();

				return response()->json([
					'success' => true,
					'redirect' => route('order.success', ['order' => $order->id])
				]);

			} catch (\Exception $e) {
				DB::rollBack();
				return response()->json([
					'success' => false,
					'message' => 'An error occurred. Please try again.'
				]);
			}
		}

		private function processDummyPayment($request)
		{
			// Simulate payment processing
			// Return true 80% of the time, false 20%
			return rand(1, 100) <= 80;
		}
	}
