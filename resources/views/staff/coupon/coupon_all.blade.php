@extends('staff.staff_dashboard')
@section('staff')
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
@endphp
<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">All Coupon </div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Coupon</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
		<a href="{{ route('add.coupon') }}" class="btn btn-primary">Add Coupon</a>
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
				<th>Coupon Name </th>
				<th>Coupon Discount  </th>
				<th>Tanggal Kupon berlaku  </th>
				<th>Tanggal Kupon berakhir</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
	@foreach($coupon as $key => $item)
			<tr>
				<td> {{ $key+1 }} </td>
				<td> {{ $item->code }}</td>
				<td>Rp {{ $item->discount }}</td>
				<td> {{ Carbon\Carbon::parse($item->valid_from)->format('D, d F Y') }}  </td>
				<td> {{ Carbon\Carbon::parse($item->valid_to)->format('D, d F Y') }}  </td>
				<td>
				<a href="{{ route('edit.coupon',$item->id) }}" class="btn btn-info">Ubah</a>
				<a href="{{ route('delete.coupon',$item->id) }}" class="btn btn-danger" id="delete" >Hapus</a>
				</td>
			</tr>
			@endforeach

		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Coupon Name </th>
				<th>Coupon Discount  </th>
				<th>Tanggal Kupon berlaku  </th>
				<th>Tanggal Kupon berakhir</th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>



			</div>




@endsection