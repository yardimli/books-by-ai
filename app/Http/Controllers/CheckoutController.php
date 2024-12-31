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
				return redirect()->route('register'); // Directly redirect the user
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
			// Base validation rules
			$baseRules = [
				'billing_name' => 'required',
				'billing_phone' => 'required',
				'billing_address' => 'required',
				'billing_zip' => 'required|numeric',
				'billing_country' => 'required',
				'shipping_name' => 'required',
				'shipping_phone' => 'required',
				'shipping_address' => 'required',
				'shipping_zip' => 'required|numeric',
				'shipping_country' => 'required',
				'card_number' => 'required|digits_between:15,16',
				'card_expiry' => ['required', 'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'],
				'card_cvv' => 'required|digits:3',
			];

			// Additional rules for Turkey (country_id = 1)
			if ($request->input('billing_country') == 1) {
				$baseRules = array_merge($baseRules, [
					'billing_city_select' => 'required',
					'billing_county_select' => 'required',
					'billing_district_select' => 'required',
					'billing_neighborhood_select' => 'required',
				]);
			} else {
				$baseRules['billing_city'] = 'required';
			}

			if ($request->input('shipping_country') == 1) {
				$baseRules = array_merge($baseRules, [
					'shipping_city_select' => 'required',
					'shipping_county_select' => 'required',
					'shipping_district_select' => 'required',
					'shipping_neighborhood_select' => 'required',
				]);
			} else {
				$baseRules['shipping_city'] = 'required';
			}


			try {
				// Validate request
				$request->validate($baseRules);

				DB::beginTransaction();

				// Process payment (dummy implementation)
				$payment_success = $this->processDummyPayment($request);
				if (!$payment_success) {
					return response()->json([
						'success' => false,
						'message' => __('default.payment_error')
					]);
				}

				// Prepare billing and shipping location data based on country
				$billingLocationData = [];
				$shippingLocationData = [];

				$quantity = $request->input('quantity', 1);
				$print_size = $request->input('print_size', 'print_13_19_5_cm');
				$base_price = $print_size === 'print_13_19_5_cm' ? 1600 : 2000;
				$subtotal = $base_price + (1000 * $quantity);
				if ($request->input('billing_country') == 1) {
					$shipping = 0; // Free shipping
				} else {
					$shipping = 600;
				}
				$total = $subtotal + $shipping;


				if ($request->input('billing_country') == 1) { // Turkey
					$billingLocationData = [
						'billing_city' => $request->input('billing_city_select'),
						'billing_county' => $request->input('billing_county_select'),
						'billing_district' => $request->input('billing_district_select'),
						'billing_neighborhood' => $request->input('billing_neighborhood_select'),
					];
				} else {
					$billingLocationData = [
						'billing_city' => $request->input('billing_city'),
						'billing_county' => null,
						'billing_district' => null,
						'billing_neighborhood' => null,
					];
				}

				if ($request->input('shipping_country') == 1) { // Turkey
					$shippingLocationData = [
						'shipping_city' => $request->input('shipping_city_select'),
						'shipping_county' => $request->input('shipping_county_select'),
						'shipping_district' => $request->input('shipping_district_select'),
						'shipping_neighborhood' => $request->input('shipping_neighborhood_select'),
					];
				} else {
					$shippingLocationData = [
						'shipping_city' => $request->input('shipping_city'),
						'shipping_county' => null,
						'shipping_district' => null,
						'shipping_neighborhood' => null,
					];
				}

				// Create order
				$order = Order::create(array_merge([
					'user_id' => auth()->id(),
					'order_number' => 'ORD-' . strtoupper(Str::random(10)),
					'subtotal' => $subtotal,
					'shipping' => $shipping,
					'total' => $total,
					'status' => __('default.pending'),
					'billing_name' => $request->input('billing_name'),
					'billing_email' => $request->input('billing_email'),
					'billing_phone' => $request->input('billing_phone'),
					'billing_address' => $request->input('billing_address'),
					'billing_zip' => $request->input('billing_zip'),
					'billing_country' => $request->input('billing_country'),
					'shipping_name' => $request->input('shipping_name'),
					'shipping_email' => $request->input('shipping_email'),
					'shipping_phone' => $request->input('shipping_phone'),
					'shipping_address' => $request->input('shipping_address'),
					'shipping_zip' => $request->input('shipping_zip'),
					'shipping_country' => $request->input('shipping_country'),
					'payment_method' => 'credit_card',
					'payment_status' => 'paid',
					'transaction_id' => 'TXN-' . strtoupper(Str::random(10))
				], $billingLocationData, $shippingLocationData));

				// Create order item
				OrderItem::create([
					'order_id' => $order->id,
					'book_guid' => $request->input('book_guid'),
					'quantity' => 1,
					'print_size' => $print_size,
					'price' => $base_price,
					'subtotal' => $base_price
				]);

				if ($quantity>0) {
					OrderItem::create([
						'order_id' => $order->id,
						'book_guid' => $request->input('book_guid'),
						'quantity' => $quantity,
						'print_size' => $print_size,
						'price' => 1000,
						'subtotal' => 1000 * $quantity
					]);
				}

				DB::commit();

				return response()->json([
					'success' => true,
					'redirect' => route('order.success', ['order' => $order->id])
				]);

			} catch (\Illuminate\Validation\ValidationException $e) {
				return response()->json(['success' => false,
					'errors' => array_values($e->errors())
				], 422);
			} catch
			(\Exception $e) {
				DB::rollBack();
				return response()->json([
					'success' => false,
					'message' => 'An error occurred. Please try again. ' . $e->getMessage()
				]);
			}
		}

		// CheckoutController.php

		public function success(Order $order)
		{
			// Ensure user can only view their own orders
			if ($order->user_id !== Auth::id()) {
				abort(403);
			}

			return view('checkout.success', compact('order'));
		}

		public function orders()
		{
			$orders = Order::where('user_id', Auth::id())
				->orderBy('created_at', 'desc')
				->get();

			return view('checkout.orders', compact('orders'));
		}

		public function orderDetails($orderNumber)
		{
			$order = Order::where([
				'order_number' => $orderNumber,
				'user_id' => Auth::id()
			])->firstOrFail();

			return view('checkout.order-details', compact('order'));
		}

		private function processDummyPayment($request)
		{
			return true;
			// Simulate payment processing
			// Return true 80% of the time, false 20%
			return rand(1, 100) <= 80;
		}
	}
