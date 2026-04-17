@extends('layouts.master-front')

@section('title')
Fruitkha - About
@endsection

@section('content')
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Organic Information</p>
						<h1>News Article</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- latest news -->
	<div class="latest-news mt-150 mb-150">
		<div class="container">
			<div class="row">
                @foreach ($news as $item)
				<div class="col-lg-4 col-md-6">
					<div class="single-latest-news">
						<a href="single-news.html">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="">
                        </a>
						<div class="news-text-box">
							<h3><a href="single-news.html">{{ $item->title }}</a></h3>
							<p class="blog-meta">
								<span class="author"><i class="fas fa-user"></i>{{Auth::guard('admin')->name }}</span>
								<span class="date"><i class="fas fa-calendar"></i>{{ $item->published_at }}</span>
							</p>
							<p class="excerpt">{{ $item->description }}</p>
							<a href="single-news.html" class="read-more-btn">read more <i class="fas fa-angle-right"></i></a>
						</div>
					</div>
				</div>
                @endforeach
			</div>

			<div class="row">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 text-center">
							<div class="pagination-wrap">
								<ul>
									<li><a href="#">Prev</a></li>
									<li><a href="#">1</a></li>
									<li><a class="active" href="#">2</a></li>
									<li><a href="#">3</a></li>
									<li><a href="#">Next</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end latest news -->


@endsection
