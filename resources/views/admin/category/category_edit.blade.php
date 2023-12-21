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
            <div class="breadcrumb-title pe-3">Edit Data Category</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Data Category</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Data Category</h5>
                <hr />

                <form id="myForm" method="post" action="{{ route('kategori.update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="category_id" value="{{ $kategori->category_id }}">

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="border border-3 p-4 rounded">

                                <div class="form-group mb-3">
                                    <label for="exampleInputUsername1">Nama Kategori:</label>
                                    <input type="text" name="category" value="{{ $kategori->name }}">
                                </div>
                            </div>

                            <div class="col-sm-9 mt-3 text-secondary">
                                <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                            </div>

                        </div><!--end row-->
                    </div>
            </div>

            </form>

        </div>

    </div>
@endsection
