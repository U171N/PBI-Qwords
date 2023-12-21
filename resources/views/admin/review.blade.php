
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
					<div class="breadcrumb-title pe-3">Reviews Kustomer</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">

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
				<th>Nama Kustomer </th>
				<th>Komentar</th>
                <th>Rating</th>
			</tr>
		</thead>
		<tbody>
			@foreach($reviews as $key => $item)
			<tr>
				<td>{{ $key+1 }}</td>
				<td>{{ $item->user->name }}</td>
				<td>
                    <div class="ms-auto star">
                        @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $item->rating)
                            <i class="bx bxs-star text-warning"></i>
                        @else
                            <i class="bx bxs-star text-light-4"></i>
                        @endif
                    @endfor
                    </div>
				</td>
			</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th>No</th>
				<th>Nama Kustomer </th>
				<th>Komentar</th>
                <th>Rating</th>
			</tr>
		</tfoot>
	</table>
						</div>
					</div>
				</div>
			</div>

@endsection

