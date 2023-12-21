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
					<div class="breadcrumb-title pe-3">All Categories</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">All Categories  <span class="badge rounded-pill bg-danger"> {{ count($categories) }} </span> </li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
		<a href="{{ route('tambah.kategori') }}" class="btn btn-primary">Add Category</a>
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
				<th>Nama Kategory </th>
				<th>Action</th> 
			</tr>
		</thead>
		<tbody>
			@foreach($categories as $key => $item)
			<tr>
				<td>{{ $key+1 }}</td>
				<td>{{ $item->name }}</td>
				<td>
<a href="{{ route('category.edit',$item->category_id) }}" class="btn btn-info" title="Edit Data"> <i class="fa fa-pencil"></i> </a>
<a href="{{ route('category.delete',$item->category_id) }}" class="btn btn-danger" id="delete" title="Delete Data" ><i class="fa fa-trash"></i></a>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Nama Kategory </th>
				<th>Action</th>
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>
 

				 
			</div>




@endsection