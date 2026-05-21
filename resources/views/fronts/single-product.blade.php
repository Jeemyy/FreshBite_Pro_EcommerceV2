@extends('layouts.master-front')
@section('title')
    Fruitkha - {{ $product->title }}
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Fresh and Organic</p>
                        <h1>{{ $product->title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- single product -->
    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ $product->title }}</h3>
                        <p class="single-product-pricing"><span>Per Kg</span> ${{ $product->price }}</p>
                        <p>{{ $product->description }}</p>
                        <form action="{{ route('fronts.cart.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="form-group">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="form-control w-25 d-inline">
                            </div>
                            <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i> Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single product -->
@endsection
