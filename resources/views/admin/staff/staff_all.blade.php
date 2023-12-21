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
					<div class="breadcrumb-title pe-3">Data Staff</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data Staff  <span class="badge rounded-pill bg-danger"> </span> </li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
		<a href="{{ route('staff.tambah') }}" class="btn btn-primary">Tambah Data Staff</a>
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
				<th>Nama </th>
				<th>No HP </th>
				<th>Foto </th>
				<th>Department </th>
				<th>Email </th>
				<th>Action</th> 
			</tr>
		</thead>
		<tbody>
			@foreach($karyawan as $key => $item)
			<tr>
				<td>{{ $key+1 }} </td>
				<td>{{ $item->name }}</td>
				<td>{{ $item->phone }}</td>
				<td>
					<img
						src="{{ (!empty($item->photo)) ? url('upload/staff_images/'.$item->photo) : url('upload/no_image.jpg') }}"
						style="width: 70px; height: 40px;"
						class="zoom-image"
					>
				</td>

				<td>{{ $item->department }}</td>
				<td>{{ $item->email }}</td>
				<td>
					<a href="{{ route('staff.edit',$item->id) }}" class="btn btn-info">Edit</a>
					<a href="{{ route('staff.delete',$item->id) }}" class="btn btn-danger" id="delete" >Delete</a>
				</td> 
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Nama </th>
				<th>No HP </th>
				<th>Foto </th>
				<th>Department </th>
				<th>Email </th>
				<th>Action</th> 
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>
 

				 
			</div>




@endsection
