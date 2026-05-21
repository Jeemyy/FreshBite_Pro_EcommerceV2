<?php

namespace App\Http\Controllers\Fronts;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return to_route('fronts.cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = Address::where('user_id', $user->id)->get();

        return view('fronts.checkout', get_defined_vars());
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cash,card',
        ]);

        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (! $cart || $cart->items->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        DB::transaction(function () use ($request, $user, $cart) {
            $total = $cart->total + 50;

            $address = Address::create([
                'user_id' => $user->id,
                'city' => $request->city,
                'street' => $request->street,
                'building' => $request->building,
                'notes' => $request->notes,
            ]);

            $payment = Payment::create([
                'user_id' => $user->id,
                'amount' => $total,
                'method' => $request->payment_method,
                'status' => 'pending',
            ]);

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'status' => 'pending',
                'payment_id' => $payment->id,
                'address_id' => $address->id,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();
        });

        return to_route('fronts.cart.success')->with('success', 'Order placed successfully!');
    }
}
