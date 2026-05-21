@extends('layouts.master-front')
@section('title')
    Fruitkha - {{ $news->title }}
@endsection
@section('content')
    <!-- breadcrumb-section -->
    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Organic Information</p>
                        <h1>{{ $news->title }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end breadcrumb section -->

    <!-- single news -->
    <div class="mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="single-article-content">
                        <div class="single-article-image mb-4">
                            <img src="{{ asset('storage/' . $news->image) }}" alt="" class="img-fluid">
                        </div>
                        <p class="blog-meta">
                            <span class="date"><i class="fas fa-calendar"></i> {{ $news->published_at }}</span>
                        </p>
                        <h3>{{ $news->title }}</h3>
                        <p>{{ $news->description }}</p>
                        <a href="{{ route('fronts.news') }}" class="boxed-btn mt-4">Back to News</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end single news -->
@endsection
