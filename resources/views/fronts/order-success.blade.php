@extends('layouts.master-front')
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>Order Placed</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- success -->
    <div class="cart-section mt-100 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="order-success-wrap">
                        <i class="fas fa-check-circle" style="font-size: 80px; color: #28a745;"></i>
                        <h2 class="mt-4">Thank You!</h2>
                        <p class="lead">Your order has been placed successfully.</p>
                        <p>We will process your order and notify you once it's ready.</p>
                        <a href="{{ route('fronts.shop') }}" class="boxed-btn mt-4">Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end success -->
@endsection
