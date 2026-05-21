@extends('layouts.master-front')
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Checkout</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- checkout -->
    <div class="cart-section mt-100 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-12 mb-5 mb-lg-0">
                    <div class="checkout-address-wrap">
                        <h4 class="mb-4">Billing Details</h4>

                        @session('error')
                            <span class="alert alert-danger">{{ session('error') }}</span>
                        @endsession

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('fronts.cart.checkout.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="city">City <span class="text-danger">*</span></label>
                                <input type="text" name="city" id="city" class="form-control" required value="{{ old('city') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="street">Street <span class="text-danger">*</span></label>
                                <input type="text" name="street" id="street" class="form-control" required value="{{ old('street') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="building">Building</label>
                                <input type="text" name="building" id="building" class="form-control" value="{{ old('building') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="notes">Order Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                            </div>

                            <h4 class="mb-3 mt-5">Payment Method</h4>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="method_cash" value="cash" checked>
                                <label class="form-check-label" for="method_cash">Cash on Delivery</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="method_card" value="card">
                                <label class="form-check-label" for="method_card">Card</label>
                            </div>

                            <button type="submit" class="boxed-btn black mt-4">Place Order</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4 offset-lg-1">
                    <div class="total-section">
                        <h4 class="mb-4">Your Order</h4>
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>Product</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->items as $item)
                                    <tr class="total-data">
                                        <td>{{ $item->product->title }} × {{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="total-data">
                                    <td><strong>Subtotal</strong></td>
                                    <td>${{ number_format($cart->total, 2) }}</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Shipping</strong></td>
                                    <td>$50.00</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>Total</strong></td>
                                    <td>${{ number_format($cart->total + 50, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end checkout -->
@endsection
