@php
$products = App\Models\Products::orderBy('product_id', 'ASC')->limit(10)->get();
$categories = App\Models\Categories::orderBy('name', 'ASC')->get();
@endphp

    <section class="product-tabs section-padding position-relative">
        <div class="container">
            <div class="section-title style-2 wow animate__animated animate__fadeIn">
                <h3> New Products </h3>
                <ul class="nav nav-tabs links" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nav-tab-one"  data-bs-toggle="tab" data-bs-target="#tab-one" type="button" role="tab" aria-controls="tab-one"  aria-selected="true">All</button>
                    </li>
@foreach($categories as $category)
<li class="nav-item" role="presentation">
    <a class="nav-link" id="nav-tab-two" data-bs-toggle="tab" href="#category{{ $category->category_id }}"  type="button" role="tab" aria-controls="tab-two" aria-selected="false">{{ $category->name }}</a>
</li>
@endforeach
                </ul>
            </div>
            <!--End nav-tabs-->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-one" role="tabpanel" aria-labelledby="tab-one">
                    <div class="row product-grid-4">

@foreach($products as $product)
<div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ route('product.details', ['id' => $product->product_id, 'slug' => $product->product_slug]) }}
                    ">
                    <img class="default-img" src="{{ asset('upload/product/' . $product->image1) }}"/>
                </a>
            </div>

@php
$amount = $product->price - $product->discount_price;
$discount = ($amount/$product->price) * 100;

@endphp


            <div class="product-badges product-badges-position product-badges-mrg">

                @if($product->discount_price == NULL)
                <span class="new">New</span>
                @else
                <span class="hot"> {{ round($discount) }} %</span>
                @endif


            </div>
        </div>
        <div class="product-content-wrap">
            <div class="product-category">
                <a href="shop-grid-right.html">{{ $product['category']['name'] }}</a>
            </div>
            <h2><a href="{{ route('product.details', ['id' => $product->product_id, 'slug' => $product->product_slug]) }}
                "> {{ $product->name }} </a></h2>
@php

$reviewcount = App\Models\ProductReview::where('product_id',$product->product_id)->latest()->get();

$avarage = App\Models\ProductReview::where('product_id',$product->product_id)->avg('rating');
@endphp

            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">

                      @if($avarage == 0)

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
                <span class="font-small ml-5 text-muted"> ({{count($reviewcount)}})</span>
            </div>



            <div class="product-card-bottom">

                @if($product->discount_price == NULL)
                 <div class="product-price">
                    <span>Rp {{ $product->price }}</span>

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
</div>
<!--end product card-->
@endforeach




                    </div>
                    <!--End product-grid-4-->
                </div>
                <!--En tab one-->



        @foreach($categories as $category)
                <div class="tab-pane fade" id="category{{ $category->category_id }}" role="tabpanel" aria-labelledby="tab-two">
                    <div class="row product-grid-4">

@php
$catwiseProduct = App\Models\Products::where('category_id',$category->category_id)->orderBy('product_id','DESC')->get();
@endphp

    @forelse($catwiseProduct as $product)
    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
    <div class="product-cart-wrap mb-30 wow animate__animated animate__fadeIn" data-wow-delay=".1s">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ route('product.details', ['id' => $product->product_id, 'slug' => $product->product_slug]) }}
                    ">
                    <img class="default-img" src="{{ !empty($product->image1) ? url('upload/product/' . $product->image1) : url('upload/no_image.jpg') }}"/>

                </a>
            </div>

@php
$amount = $product->price - $product->discount_price;
$discount = ($amount/$product->price) * 100;

@endphp


            <div class="product-badges product-badges-position product-badges-mrg">

                @if($product->discount_price == NULL)
                <span class="new">New</span>
                @else
                <span class="hot"> {{ round($discount) }} %</span>
                @endif


            </div>
        </div>
        <div class="product-content-wrap">
            <div class="product-category">
                <a href="shop-grid-right.html">{{ $product['category']['name'] }}</a>
            </div>
            <h2><a href="{{ route('product.details', ['id' => $product->product_id, 'slug' => $product->product_slug]) }}
                "> {{ $product->name }} </a></h2>
            <div class="product-rate-cover">
                <div class="product-rate d-inline-block">
                    <div class="product-rating" style="width: 90%"></div>
                </div>
                <span class="font-small ml-5 text-muted"> (4.0)</span>
            </div>

            <div class="product-card-bottom">

                @if($product->discount_price == NULL)
                 <div class="product-price">
                    <span>Rp {{ $product->price }}</span>

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
</div>
<!--end product card-->

    @empty

    <h5 class="text-danger"> No Product Found </h5>


    @endforelse




                    </div>
                    <!--End product-grid-4-->
                </div>
                <!--En tab two-->
                @endforeach


            </div>
            <!--End tab-content-->
        </div>
    </section>