@extends('admin.admin_dashboard')
@section('admin')
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
@endphp
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Product</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Product  <span class="badge rounded-pill bg-danger"> {{ count($products) }} </span> </li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
		<a href="{{ route('tambah.product') }}" class="btn btn-primary">Add Product</a>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
			<tr>
				<th>No</th>
				<th>Gambar Produk 1</th>
				<th>Gambar Produk 2</th>
				<th>Gambar Produk 3</th>
				<th>Product Name </th>
				<th>Description</th>
				<th>Price </th>
				<th>Stock </th>
				<th>Discount </th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($products as $key =>$item)
			<tr>
				<td>{{ $key+1 }}</td>
				<td> <img
					src="{{ (!empty($item->image1)) ? url('upload/product/'.$item->image1) : url('upload/no_image.jpg') }}"
					style="width: 70px; height: 40px;"
					class="zoom-image"
				> </td>

				<td> <img
					src="{{ (!empty($item->image2)) ? url('upload/product/'.$item->image2) : url('upload/no_image.jpg') }}"
					style="width: 70px; height: 40px;"
					class="zoom-image"
				> </td>

				<td> <img
					src="{{ (!empty($item->image3)) ? url('upload/product/'.$item->image3) : url('upload/no_image.jpg') }}"
					style="width: 70px; height: 40px;"
					class="zoom-image"
				> </td>
				<td>{{$item->name}}</td>
				<td>{{ $item->description }}</td>
				<td>Rp{{ number_format($item->price, 2) }}</td>
				<td>{{ $item->amount }}</td>
				<td>{{ $item->discount_price }}</td>
				<td>
<a href="{{ route('edit.product', $item->product_id) }}" class="btn btn-info" title="Edit Data"> <i class="fa fa-pencil"></i> </a>
<a href="{{ route('delete.product', $item->product_id) }}" class="btn btn-danger" id="delete" title="Delete Data" ><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Gambar Produk 1</th>
				<th>Gambar Produk 2</th>
				<th>Gambar Produk 3</th>
				<th>Product Name </th>
				<th>Description</th>
				<th>Price </th>
				<th>Stock </th>
				<th>Discount </th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>



			</div>




@endsection