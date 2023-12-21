@extends('admin.admin_dashboard')
@section('admin')
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
@endphp
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <div class="page-content">

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Edit Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Product</h5>
                <hr />

                <form id="myForm" method="post" action="{{ route('update.product') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->product_id }}">
                    <input type="hidden" name="category_id" value="{{ $product->category_id }}">

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="border border-3 p-4 rounded">


                                    <div class="form-group mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control"
                                            id="inputProductTitle" placeholder="Enter product title">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="inputProductDescription" class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="inputProductTitle" class="form-label">Foto produk 1</label>
                                        <input class="form-control" name="image1" type="file">

                                        <div class="row" id="preview_img"></div>

                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="inputProductTitle" class="form-label">Foto produk 2</label>
                                        <input class="form-control" name="image2" type="file">

                                        <div class="row" id="preview_img"></div>

                                    </div>


                                    <div class="form-group mb-3">
                                        <label for="inputProductTitle" class="form-label">Foto produk 3</label>
                                        <input class="form-control" name="image3" type="file">

                                        <div class="row" id="preview_img"></div>

                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="exampleInputUsername1">Jenis Kategori:</label>
                                        <select name="category" class="form-control">
                                            <option value="">--Pilih Kategori--</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->category_id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Size</label>
                                        <input type="text" name="product_size" class="form-control visually-hidden" data-role="tagsinput" value="Small,Midium,Large,Extra Large" readonly>
                                      </div>

                                      <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Product Color</label>
                                        <input type="text" name="product_color" class="form-control">
                                      </div>

                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="border border-3 p-4 rounded">
                                    <div class="row g-3">

                                        <div class="form-group col-md-6">
                                            <label for="inputStarPoints" class="form-label">Berat (Gram)</label>
                                            <input type="text" name="product_weight" class="form-control"
                                                id="inputStarPoints" placeholder="00.00">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputPrice" class="form-label">Product Price</label>
                                            <input type="text" name="selling_price" class="form-control" id="inputPrice"
                                                placeholder="00.00">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputCompareatprice" class="form-label">Discount Price </label>
                                            <input type="text" name="discount_price" class="form-control"
                                                id="inputCompareatprice" placeholder="00.00">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="inputStarPoints" class="form-label">Stock Produk</label>
                                            <input type="text" name="product_qty" class="form-control"
                                                id="inputStarPoints" placeholder="00.00">
                                        </div>

                                        <hr>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <input type="submit" class="btn btn-primary px-4" value="Save Changes" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
            </div>

            </form>

        </div>

    </div>
@endsection
