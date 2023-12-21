@extends('frontend.master_dashboard')
@section('main')

@section('title')
    Toko Kain Khas Kudus
@endsection

{{-- @include('frontend.home.home_slider') --}}

<!--End hero slider-->


@include('frontend.home.products')

<!--Products Tabs-->





{{--
<!-- Fashion Category -->
<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>{{ $skip_category_0->name ?? '' }} Category</h3>

        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">

                    @if ($skip_product_0 && is_array($skip_product_0))
                    @foreach ($skip_product_0 as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}">
                                                <img class="default-img"
                                                    src="{{ asset($product->image1) }}" alt="" />

                                            </a>
                                        </div>


                                        @php
                                            $amount = $product->price - $product->discount_price;
                                            $discount = ($amount / $product->price) * 100;

                                        @endphp


                                        <div class="product-badges product-badges-position product-badges-mrg">

                                            @if ($product->discount_price == null)
                                                <span class="new">New</span>
                                            @else
                                                <span class="hot"> {{ round($discount) }} %</span>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a
                                                href="shop-grid-right.html">{{ $product['category']['name'] }}</a>
                                        </div>
                                        <h2><a
                                                href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}">
                                                {{ $product->name }} </a></h2>
                                        @php

                                            $reviewcount = App\Models\ProductReview::where('product_id', $product->product_id)
                                                ->where('status', 1)
                                                ->latest()
                                                ->get();

                                            $avarage = App\Models\ProductReview::where('product_id', $product->product_id)
                                                ->where('status', 1)
                                                ->avg('rating');
                                        @endphp

                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                @if ($avarage == 0)
                                                @elseif($avarage == 1 || $avarage < 2)
                                                    <div class="product-rating" style="width: 20%"></div>
                                                @elseif($avarage == 2 || $avarage < 3)
                                                    <div class="product-rating" style="width: 40%"></div>
                                                @elseif($avarage == 3 || $avarage < 4)
                                                    <div class="product-rating" style="width: 60%"></div>
                                                @elseif($avarage == 4 || $avarage < 5)
                                                    <div class="product-rating" style="width: 80%"></div>
                                                @elseif($avarage == 5 || $avarage < 5)
                                                    <div class="product-rating" style="width: 100%"></div>
                                                @endif
                                            </div>
                                            <span class="font-small ml-5 text-muted">
                                                ({{ count($reviewcount) }})</span>
                                        </div>

                                        <div class="product-card-bottom">

                                            @if ($product->discount_price == null)
                                                <div class="product-price">
                                                    <span>${{ $product->price }}</span>

                                                </div>
                                            @else
                                                <div class="product-price">
                                                    <span>${{ $product->discount_price }}</span>
                                                    <span class="old-price">${{ $product->price }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                        @endforeach
                        @else
                        <p>No products available.</p>
                    @endif





                </div>
                <!--End product-grid-4-->
            </div>


        </div>
        <!--End tab-content-->
    </div>


</section>
<!--End Fashion Category -->





<!-- SweetHome Category -->

<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>{{ $skip_category_2->name ?? '' }} Category </h3>

        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @if ($skip_category_2 && is_array($skip_category_2))
                    @foreach ($skip_category_2 as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}">
                                                <img class="default-img"
                                                    src="{{ asset($product->image1) }}" alt="" />

                                            </a>
                                        </div>
                                        @php
                                            $amount = $product->price - $product->discount_price;
                                            $discount = ($amount / $product->price) * 100;

                                        @endphp


                                        <div class="product-badges product-badges-position product-badges-mrg">

                                            @if ($product->discount_price == null)
                                                <span class="new">New</span>
                                            @else
                                                <span class="hot"> {{ round($discount) }} %</span>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a
                                                href="shop-grid-right.html">{{ $product['category']['name'] }}</a>
                                        </div>
                                        <h2><a
                                                href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}">
                                                {{ $product->name }} </a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>

                                        <div class="product-card-bottom">

                                            @if ($product->discount_price == null)
                                                <div class="product-price">
                                                    <span>${{ $product->price }}</span>

                                                </div>
                                            @else
                                                <div class="product-price">
                                                    <span>${{ $product->discount_price }}</span>
                                                    <span class="old-price">${{ $product->price }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                        @endforeach
                        @else
                <p>No products available.</p>
                    @endif





                </div>
                <!--End product-grid-4-->
            </div>


        </div>
        <!--End tab-content-->
    </div>


</section>
<!--End SweetHome Category -->









<!-- Mobile Category -->

<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__animated animate__fadeIn">
            <h3>{{ $skip_category_7->name ?? '' }} Category </h3>

        </div>
        <!--End nav-tabs-->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                <div class="row product-grid-4">
                    @if ($skip_product_7 && is_array($skip_product_7))
                        @foreach ($skip_product_7 as $product)
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn"
                                    data-wow-delay=".1s">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a
                                                href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}">
                                                <img class="default-img"
                                                    src="{{ asset($product->image1) }}"
                                                    alt="" />

                                            </a>
                                        </div>

                                        @php
                                            $amount = $product->price - $product->discount_price;
                                            $discount = ($amount / $product->price) * 100;

                                        @endphp


                                        <div class="product-badges product-badges-position product-badges-mrg">

                                            @if ($product->discount_price == null)
                                                <span class="new">New</span>
                                            @else
                                                <span class="hot"> {{ round($discount) }} %</span>
                                            @endif


                                        </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <div class="product-category">
                                            <a
                                                href="shop-grid-right.html">{{ $product['category']['name'] }}</a>
                                        </div>
                                        <h2><a
                                                href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}">
                                                {{ $product->name }} </a></h2>
                                        <div class="product-rate-cover">
                                            <div class="product-rate d-inline-block">
                                                <div class="product-rating" style="width: 90%"></div>
                                            </div>
                                            <span class="font-small ml-5 text-muted"> (4.0)</span>
                                        </div>

                                        <div class="product-card-bottom">

                                            @if ($product->discount_price == null)
                                                <div class="product-price">
                                                    <span>${{ $product->price }}</span>

                                                </div>
                                            @else
                                                <div class="product-price">
                                                    <span>${{ $product->discount_price }}</span>
                                                    <span class="old-price">${{ $product->price }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end product card-->
                        @endforeach
                        @else
                <p>No products available.</p>
                    @endif





                </div>
                <!--End product-grid-4-->
            </div>


        </div>
        <!--End tab-content-->
    </div>


</section>
<!--End Mobile Category --> --}}

@endsection
