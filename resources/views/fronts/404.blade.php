@extends('layouts.master-front')
@section('title')
    Fruitkha - 404
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Page Not Found</p>
                        <h1>404</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- 404 -->
    <div class="cart-section mt-100 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="404-wrap">
                        <h2 class="mb-4" style="font-size: 120px; color: #F28123;">404</h2>
                        <h3>Oops! Page not found</h3>
                        <p>The page you are looking for does not exist.</p>
                        <a href="{{ route('fronts.index') }}" class="boxed-btn mt-4">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end 404 -->
@endsection
