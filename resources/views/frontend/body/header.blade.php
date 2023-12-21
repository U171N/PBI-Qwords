<!-- Header  -->
<header class="header-area header-style-1 header-height-2">
    <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div>
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info">
                        <ul>

                            <li><a href="{{ route('mycart') }}">My Cart</a></li>
                            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                            <li><a href="{{ route('order.customer') }}">Cek Pesanan</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                            <ul>
                                <li>100% Secure delivery without contacting the courier</li>
                                <li>Supper Value Deals - Save more with coupons</li>
                                <li>Trendy 25silver jewelry, save up 35% off today</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>

                            <li>Need help? Call Us: <strong class="text-brand"> + 1800 900</strong></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="index.html"><img src="" alt="logo" /></a>
                </div>
                <div class="header-right">


                    <div class="search-style-2">

                        <form action="{{ route('product.search') }}" method="post">
                            @csrf
                            <input onfocus="search_result_show()" onblur="search_result_hide()" name="search"
                                id="search2" placeholder="Search for items..." />
                            <div id="searchProducts2"></div>
                        </form>
                    </div>

                </div>
                <div class="header-action-right">
                    <div class="header-action-2">


                        <div class="header-action-icon-2">
                            <a href="{{ route('wishlist') }}">
                                <img class="svgInject" alt="Nest"
                                    src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                <span class="pro-count blue" id="wishQty">0 </span>
                            </a>
                            <a href="{{ route('wishlist') }}"><span class="lable">Wishlist</span></a>
                        </div>






                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="shop-cart.html">
                                <img alt="Nest"
                                    src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                <span class="pro-count blue" id="cartQty">0</span>
                            </a>
                            <a href="{{ route('mycart') }}"><span class="lable">Cart</span></a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2">


                                <!--   // mini cart start with ajax -->
                                <div id="miniCart">

                                </div>

                                <!--   // End mini cart start with ajax -->





                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span id="cartSubTotal"> </span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="{{ route('mycart') }}" class="outline">View cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="header-action-icon-2">
                            <img class="svgInject" alt="Nest"
                                src="{{ asset('frontend/assets/imgs/theme/icons/icon-user.svg') }}" />
                            @auth
                                <span class="lable ml-0">Account</span>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li>
                                            <a href="{{ route('update.profile.customer') }}"><i
                                                    class="fi fi-rs-user mr-10"></i>My
                                                Account</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('order.customer') }}"><i
                                                    class="fi fi-rs-location-alt mr-10"></i>Cek Pesanan</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('detailOrder.customer') }}"><i class="fi fi-rs-label mr-10"></i>Riwayat Pesanan</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('wishlist') }}"><i class="fi fi-rs-heart mr-10"></i>My
                                                Wishlist</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('customer.ubah.password') }}"><i
                                                    class="fi fi-rs-settings-sliders mr-10"></i>Ubah Password</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('user.logout') }}"><i
                                                    class="fi fi-rs-sign-out mr-10"></i>Sign out</a>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>

                                <span class="lable" style="margin-left: 2px; margin-right: 2px;"> | </span>


                                <a href="{{ route('register') }}"><span class="lable ml-0">Register</span></a>

                            @endauth




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





    @php

        $categories = App\Models\Categories::orderBy('name', 'ASC')->get();
    @endphp


    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="index.html"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}"
                            alt="logo" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi-rs-apps"></span> All Categories
                            <i class="fi-rs-angle-down"></i>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categori-dropdown-inner">
                                <ul>
                                    @foreach ($categories as $item)
                                        @if ($loop->index < 5)
                                            <li>
                                                <a
                                                    href="{{ url('product/category/' . $item->category_id . '/' . $item->category_slug) }}">
                                                    {{ $item->name }} </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                                <ul class="end">
                                    @foreach ($categories as $item)
                                        @if ($loop->index > 4)
                                            <li>
                                                <a
                                                    href="{{ url('product/category/' . $item->category_id . '/' . $item->category_slug) }}">
                                                    {{ $item->name }} </a>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>
                            <div class="more_slide_open" style="display: none">

                            </div>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>

                                <li>
                                    <a class="active" href="{{ url('/') }}">Home </a>

                                </li>


                                <li>
                                    <a href="{{ route('shop.page') }}">Shop</a>
                                </li>
                                <li>
                                    <a href="mailto: xyz480167@gmail.com" target="_blank">Contact</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>


                <div class="hotline d-none d-lg-flex">
                    <img src="{{ asset('frontend/assets/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                    <p>123456789<span>24/7 Support Center</span></p>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2">
                            <a href="{{ route('wishlist') }}">
                                <img class="svgInject" alt="Nest"
                                    src="{{ asset('frontend/assets/imgs/theme/icons/icon-heart.svg') }}" />
                                <span class="pro-count blue" id="wishQty">0 </span>
                            </a>
                            <a href="{{ route('wishlist') }}"><span class="lable">Wishlist</span></a>
                        </div>
                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="shop-cart.html">
                                <img alt="Nest"
                                    src="{{ asset('frontend/assets/imgs/theme/icons/icon-cart.svg') }}" />
                                <span class="pro-count blue" id="cartQty">0</span>
                            </a>
                            <a href="{{ route('mycart') }}"><span class="lable">Cart</span></a>

                            <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                <div id="miniCart">

                                </div>
                                <div class="shopping-cart-footer">
                                    <div class="shopping-cart-total">
                                        <h4>Total <span id="cartSubTotal"> </span></h4>
                                    </div>
                                    <div class="shopping-cart-button">
                                        <a href="{{ route('mycart') }}" class="outline">View cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- End Header  -->
<style>
    #searchProducts {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #ffffff;
        z-index: 999;
        border-radius: 8px;
        margin-top: 5px;
    }
</style>

<script>
    function search_result_show() {
        $("#searchProducts").slideDown();

    }

    function search_result_hide() {
        $("#searchProducts").slideUp();
    }
</script>


<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="index.html"><img src="{{ asset('frontend/assets/imgs/theme/logo.svg') }}"
                        alt="logo" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ route('product.search') }}" method="post">
                    @csrf

                    <input onfocus="search_result_show()" onblur="search_result_hide()" name="search"
                        id="search" placeholder="Search for items..." />
                    <div id="searchProducts"></div>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <!-- mobile menu start -->
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li class="menu-item-has-children">
                            <a class="active" href="{{ url('/') }}">Home </a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="{{ route('shop.page') }}">Shop</a>
                        </li>

                        <li class="menu-item-has-children">
                            <a href="#">All Categories</a>
                            <ul class="dropdown">
                                @foreach ($categories as $item)
                                    @if ($loop->index < 5)
                                        <li>
                                            <a
                                                href="{{ url('product/category/' . $item->category_id . '/' . $item->category_slug) }}">
                                                {{ $item->name }} </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <ul class="end">
                                @foreach ($categories as $item)
                                    @if ($loop->index > 4)
                                        <li>
                                            <a
                                                href="{{ url('product/category/' . $item->category_id . '/' . $item->category_slug) }}">
                                                {{ $item->name }} </a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="#">Pages</a>
                            @auth
                                <ul class="dropdown">
                                    <li>
                                        <a href="{{ route('update.profile.customer') }}"><i
                                                class="fi fi-rs-user mr-10"></i>My
                                            Account</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard') }}"><i
                                                class="fi fi-rs-location-alt mr-10"></i>Order Tracking</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard') }}"><i class="fi fi-rs-label mr-10"></i>My
                                            Voucher</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('dashboard') }}"><i class="fi fi-rs-heart mr-10"></i>My
                                            Wishlist</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('customer.ubah.password') }}"><i
                                                class="fi fi-rs-settings-sliders mr-10"></i>Ubah Password</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.logout') }}"><i class="fi fi-rs-sign-out mr-10"></i>Sign
                                            out</a>
                                    </li>
                                </ul>
                            @else
                                <ul class="dropdown">
                                    <li>
                                        <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>

                                        <span class="lable" style="margin-left: 2px; margin-right: 2px;"> | </span>


                                        <a href="{{ route('register') }}"><span class="lable ml-0">Register</span></a>
                                    </li>

                                </ul>
                            @endauth

                        </li>
                    </ul>
                </nav>
                <!-- mobile menu end -->
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{ route('register') }}"><span class="lable ml-0">Register</span></a>
                </div>
                <div class="single-mobile-header-info">
                    <i class="fi-rs-headphones"></i>(+01) - 2345 - 6789
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-facebook-white.svg') }}"
                        alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-twitter-white.svg') }}"
                        alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-instagram-white.svg') }}"
                        alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-pinterest-white.svg') }}"
                        alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-youtube-white.svg') }}"
                        alt="" /></a>
            </div>
            <div class="site-copyright">Copyright 2022 © Nest. All rights reserved. Powered by AliThemes.</div>
        </div>
    </div>
</div>
