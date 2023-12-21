@extends('frontend.master_dashboard')
@section('main')

@section('title')
    {{ $product->name }}
@endsection

<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> <a
                href="shop-grid-right.html">{{ $product['category']['name'] }}</a><span></span>{{ $product->name }}
        </div>
    </div>
</div>
<div class="container mb-30">
    <div class="row">
        <div class="col-xl-10 col-lg-12 m-auto">
            <div class="product-detail accordion-detail">
                <div class="row mb-50 mt-30">
                    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div id="productImageCarousel" class="carousel slide" data-ride="carousel">
                            <!-- MAIN SLIDES -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ !empty($product->image1) ? url('upload/product/' . $product->image1) : url('upload/no_image.jpg') }}"
                                        class="d-block w-100" alt="Product Image 1" style="max-height: 300px;">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ !empty($product->image2) ? url('upload/product/' . $product->image2) : url('upload/no_image.jpg') }}"
                                        class="d-block w-100" alt="Product Image 2" style="max-height: 300px;">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ !empty($product->image3) ? url('upload/product/' . $product->image3) : url('upload/no_image.jpg') }}"
                                        class="d-block w-100" alt="Product Image 3" style="max-height: 300px;">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#productImageCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#productImageCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <!-- THUMBNAILS -->
                        <div class="slider-nav-thumbnails mt-3">
                            <div class="thumbnail-item active">
                                <img src="{{ asset('upload/product/' . $product->image1) }}"
                                    alt="Thumbnail 1" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="thumbnail-item">
                                <img src="{{ asset('upload/product/' . $product->image2) }}"
                                    alt="Thumbnail 2" style="max-width: 100px; max-height: 100px;">
                            </div>
                            <div class="thumbnail-item">
                                <img src="{{ asset('upload/product/' . $product->image3) }}"
                                    alt="Thumbnail 3" style="max-width: 100px; max-height: 100px;">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <div class="detail-info pr-30 pl-30">
                            @if ($product->amount > 0)
                                <span class="stock-status in-stock">In Stock </span>
                            @else
                                <span class="stock-status out-stock">Stock Out </span>
                            @endif



                            <h2 class="title-detail" id="dpname"> {{ $product->name }} </h2>
                            <div class="product-detail-rating">
                                <div class="product-rate-cover text-end">

                                    @php

                                        $reviewcount = App\Models\ProductReview::where('product_id', $product->product_id)
                                            ->latest()
                                            ->get();

                                        $avarage = App\Models\ProductReview::where('product_id', $product->product_id)->avg('rating');
                                    @endphp


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



                                    <span class="font-small ml-5 text-muted"> ({{ count($reviewcount) }} reviews)</span>
                                </div>
                            </div>
                            <div class="clearfix product-price-cover">
                                @php
                                    $amount = $product->price - $product->discount_price;
                                    $discount = ($amount / $product->price) * 100;
                                @endphp

                                @if ($product->discount_price == null)
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">Rp {{ $product->price }}</span>

                                    </div>
                                @else
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand">Rp {{ $product->discount_price }}</span>
                                        <span>
                                            <span class="save-price font-md color3 ml-15">{{ round($discount) }}%
                                                Off</span>
                                            <span class="old-price font-md ml-15">Rp {{ $product->price }}</span>
                                        </span>
                                    </div>

                                @endif
                            </div>


                            @if($product->product_size == NULL)

                            @else

                       <div class="attr-detail attr-size mb-30">
                               <strong class="mr-10" style="width:50px;">Size : </strong>
                                <select class="form-control unicase-form-control" id="dsize">
                                    <option selected="" disabled="">--Choose Size--</option>
                                    @foreach($product_size as $size)
                                    <option value="{{ $size }}">{{ ucwords($size)  }}</option>
                                    @endforeach
                                </select>
                           </div>


                            @endif


                             @if($product->product_color == NULL)

                            @else

                       <div class="attr-detail attr-size mb-30">
                               <strong class="mr-10" style="width:50px;">Color : </strong>
                                <select class="form-control unicase-form-control" id="dcolor">
                                    <option selected="" disabled="">--Choose Color--</option>
                                    @foreach($product_color as $color)
                                    <option value="{{ $color }}">{{ ucwords($color)  }}</option>
                                    @endforeach
                                </select>
                           </div>


                            @endif

                            <div class="attr-detail attr-size mb-30">
                                <strong class="mr-10" style="width:50px;">Berat : </strong>
                                <input type="text" id="dproduct_weight" value="{{ $product->product_weight }}" readonly>
                            </div>

                            <div class="detail-extralink mb-50">
                                <div class="detail-qty border radius">
                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                    <input type="text" name="quantity" id="dqty" class="qty-val" value="1"
                                        min="1">
                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                </div>
                                <div class="product-extra-link2">

                                    <input type="hidden" id="dproduct_id" value="{{ $product->product_id }}">


                                    <button type="submit" class="button button-add-to-cart" onclick="addToCartDetails()"><i class="fi-rs-shopping-cart"></i>Add to cart</button>


                                    <a aria-label="Add To Wishlist" id="{{ $product->product_id }}" onclick="addToWishList(this.id)" class="action-btn hover-up"
                                        ><i class="fi-rs-heart"></i></a>
                                </div>
                            </div>

                            <hr>

                            <div class="font-xs">
                                <ul class="mr-50 float-start">

                                    <li class="mb-5">Category:<span class="text-brand">
                                            {{ $product['category']['name'] }}</span></li>
                                </ul>

                                <ul class="float-start">
                                    <li>Stock:<span class="in-stock text-brand ml-5">({{ $product->amount }}) Items In
                                            Stock</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- Detail Info -->
                    </div>
                </div>
                <div class="product-info">
                    <div class="tab-style3">
                        <ul class="nav nav-tabs text-uppercase">
                            <li class="nav-item">
                                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                    href="#Description">Description</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews
                                    ({{ count($reviewcount) }})</a>
                            </li>
                        </ul>
                        <div class="tab-content shop_info_tab entry-main-content">
                            <div class="tab-pane fade show active" id="Description">
                                <div class="">
                                    <p> {!! $product->description !!} </p>

                                </div>
                            </div>


                        </div>


                        <div class="tab-pane fade" id="Reviews">
                            <!--Comments-->
                            <div class="comments-area">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="mb-30">Customer questions & answers</h4>
                                        <div class="comment-list">
                                            @php
                                                $reviews = App\Models\ProductReview::where('product_id', $product->product_id)
                                                    ->latest()
                                                    ->limit(5)
                                                    ->get();
                                            @endphp

                                            @foreach ($reviews as $item)
                                                @if ($item->status == 0)
                                                @else
                                                    <div class="single-comment justify-content-between d-flex mb-30">
                                                        <div class="user justify-content-between d-flex">
                                                            <div class="thumb text-center">
                                                                <img src="{{ !empty($item->user->photo) ? url('upload/user_images/' . $item->user->photo) : url('upload/no_image.jpg') }}"
                                                                    alt="" />
                                                                <a href="#"
                                                                    class="font-heading text-brand">{{ $item->user->name }}</a>
                                                            </div>
                                                            <div class="desc">
                                                                <div class="d-flex justify-content-between mb-10">
                                                                    <div class="d-flex align-items-center">
                                                                        <span class="font-xs text-muted">
                                                                            {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="product-rate d-inline-block">

                                                                        @if ($item->rating == null)
                                                                        @elseif($item->rating == 1)
                                                                            <div class="product-rating"
                                                                                style="width: 20%"></div>
                                                                        @elseif($item->rating == 2)
                                                                            <div class="product-rating"
                                                                                style="width: 40%"></div>
                                                                        @elseif($item->rating == 3)
                                                                            <div class="product-rating"
                                                                                style="width: 60%"></div>
                                                                        @elseif($item->rating == 4)
                                                                            <div class="product-rating"
                                                                                style="width: 80%"></div>
                                                                        @elseif($item->rating == 5)
                                                                            <div class="product-rating"
                                                                                style="width: 100%"></div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <p class="mb-10">{{ $item->comment }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach


                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <h4 class="mb-30">Customer reviews</h4>
                                        <div class="d-flex mb-30">
                                            <div class="product-rate d-inline-block mr-15">
                                                <div class="product-rating" style="width: {{ $averageRating }}%"></div>
                                            </div>
                                            <h6>{{ $averageRating }} dari 100</h6>
                                        </div>
                                        @foreach ([5, 4, 3, 2, 1] as $rating)
                                        @if ($ratingDistribution->has($rating))
                                            <div class="progress">
                                                <span>{{ $rating }} star</span>
                                                <div class="progress-bar" role="progressbar" style="width: {{ $ratingDistribution[$rating] }}%"
                                                    aria-valuenow="{{ $ratingDistribution[$rating] }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($ratingDistribution[$rating], 1) }}%
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>





                            <!--comment form-->
                            <div class="comment-form">
                                <h4 class="mb-15">Testimoni</h4>

                                @guest
                                    <p> <b>For Add Product Review. You Need To Login First <a
                                                href="{{ route('login') }}">Login Here </a> </b></p>
                                @else
                                    <div class="row">
                                        <div class="col-lg-8 col-md-12">
                                            <div class="card radius-10 w-100">
                                                <div class="card-header border-bottom bg-transparent">
                                                    <div class="d-flex align-items-center">

                                                        <div class="font-22 ms-auto">
                                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    @foreach($reviews as $review)

                                                    <li class="list-group-item bg-transparent">
                                                        <div class="d-flex align-items-center">
                                                            <img src="assets/images/avatars/avatar-1.png" alt="user avatar" class="rounded-circle"
                                                                width="55" height="55" />
                                                            <div class="ms-3">
                                                                <p class="mb-0 small-font">
                                                                    {{ $review->user->name }}: {{ $review->comment }}
                                                                </p>
                                                            </div>
                                                            <div class="ms-auto star">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $review->rating)
                                                                    <i class="bx bxs-star text-warning"></i>
                                                                @else
                                                                    <i class="bx bxs-star text-light-4"></i>
                                                                @endif
                                                            @endfor
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                @endguest


                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row mt-60">
                <div class="col-12">
                    <h2 class="section-title style-1 mb-30">Related products</h2>
                </div>
                <div class="col-12">
                    <div class="row related-products">


                        @foreach ($relatedProduct as $product)
                            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap hover-up">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="{{ url('product/details/' . $product->product_id . '/' . $product->product_slug) }}"
                                                tabindex="0">
                                                <img class="default-img" src="{{ (!empty($product->image3)) ? url('upload/product/'.$product->image3) : url('upload/no_image.jpg') }}"
                                                alt="" class="zoom-image" />

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
                                        <h2><a href="shop-product-right.html"
                                                tabindex="0">{{ $product->product_name }}</a></h2>
                                        <div class="rating-result" title="90%">
                                            <span> </span>
                                        </div>

                                        @if ($product->discount_price == null)
                                            <div class="product-price">
                                                <span>${{ $product->price }}</span>

                                            </div>
                                        @else
                                            <div class="product-price">
                                                <span>Rp {{ $product->discount_price }}</span>
                                                <span class="old-price">Rp {{ $product->price }}</span>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


@endsection
