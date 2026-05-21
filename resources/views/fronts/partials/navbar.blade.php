<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    <!-- logo -->
                    <div class="site-logo">
                        <a href="index.html">
                            <img src="{{ asset('assets-front') }}/img/logo.png" alt="">
                        </a>
                    </div>
                    <!-- logo -->

                    <!-- menu start -->
                    <nav class="main-menu">
                        <ul>
                            <li class="current-list-item"><a href="#">Home</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('fronts.index') }}">Static Home</a></li>
                                    <li><a href="{{ route('fronts.index') }}">Slider Home</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('fronts.about') }}">About</a></li>
                            <li><a href="#">Pages</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('fronts.index') }}">404 page</a></li>
                                    <li><a href="{{ route('fronts.about') }}">About</a></li>
                                    <li><a href="{{ route('fronts.cart.index') }}">Cart</a></li>
                                    <li><a href="{{ route('fronts.cart.checkout') }}">Check Out</a></li>
                                    <li><a href="{{ route('fronts.contact') }}">Contact</a></li>
                                    <li><a href="{{ route('fronts.news') }}">News</a></li>
                                    <li><a href="{{ route('fronts.shop') }}">Shop</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('fronts.news') }}">News</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('fronts.news') }}">News</a></li>
                                    <li><a href="{{ route('fronts.news') }}">Single News</a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('fronts.contact') }}">Contact</a></li>
                            <li><a href="{{ route('fronts.shop') }}">Shop</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('fronts.shop') }}">Shop</a></li>
                                    <li><a href="{{ route('fronts.cart.checkout') }}">Check Out</a></li>
                                    <li><a href="{{ route('fronts.shop') }}">Single Product</a></li>
                                    <li><a href="{{ route('fronts.cart.index') }}">Cart</a></li>
                                </ul>
                            </li>
                            <li>
                                <div class="header-icons">
                                    <a class="shopping-cart" href="{{ route('fronts.cart.index') }}"><i
                                            class="fas fa-shopping-cart"></i></a>
                                    <a class="mobile-hide search-bar-icon" href="#"><i
                                            class="fas fa-search"></i></a>
                                    @guest
                                    <a href="{{ route('login') }}">Login</a>
                                    @endguest
                                    @auth

                                    <form action="{{ route('logout') }}" method="POST" style="display: inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Logout</button>
                                    </form>
                                    @endauth

                                </div>
                            </li>
                        </ul>
                    </nav>
                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                    <div class="mobile-menu"></div>
                    <!-- menu end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- search area -->
<div class="search-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="close-btn"><i class="fas fa-window-close"></i></span>
                <div class="search-bar">
                    <div class="search-bar-tablecell">
                        <h3>Search For:</h3>
                        <input type="text" placeholder="Keywords">
                        <button type="submit">Search <i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end search area -->
