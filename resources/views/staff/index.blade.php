@extends('staff.staff_dashboard')
@section('staff')
@php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
@endphp
    <!--start page wrapper -->
    <div class="page-content">
        <div class="row-cols-xl-8 d-flex">
            <div class="col">
                <div class="card radius-10 bg-gradient-deepblue">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $totalSoldProducts }}</h5>
                            <div class="ms-auto">
                           <i class="bx bx-cart fs-3 text-white"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Orders</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mr-5">
                <div class="card radius-10 bg-gradient-orange">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">Rp {{ number_format($totalRevenue, 2) }}</h5>
                            <div class="ms-auto">
                         <i class="bx bx-dollar fs-3 text-white"></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Total Pendapatan</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col mr-3">
                <div class="card radius-10 bg-gradient-ohhappiness">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0 text-white">{{ $totalCustomer }}</h5>
                            <div class="ms-auto">
                          <i class="bx bx-group fs-3 text-white"></i>
                            </div>
                        </div>

                        <div class="d-flex align-items-center text-white">
                            <p class="mb-0">Customer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->

        <div class="row">

            <div class="col-12 col-lg-6 col-xl-12 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-header border-bottom bg-transparent">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0">Feedback Customer</h6>
                            </div>
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
        <!--End Row-->

        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="mb-0">Riwayat Order</h5>
                    </div>
                    <div class="font-22 ms-auto">
                        <i class="bx bx-dots-horizontal-rounded"></i>
                    </div>
                </div>
                <hr />
                <div class="table-responsive">
                    <table  id="example" class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order id</th>
                                <th>Product</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                @foreach ($order->orderItems as $orderItem)
                                    <tr>
                                        <td>#{{ $order->order_id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="recent-product-img">
                                                    <img src="{{ asset('upload/product/' . $orderItem->product->image1) }}" alt="" />
                                                </div>
                                                <div class="ms-2">
                                                    <h6 class="mb-1 font-14">{{ $orderItem->product->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>Rp {{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            @php
                                                $statusText = '';
                                                switch ($order->status) {
                                                    case 0:
                                                        $statusText = 'Sedang Diproses';
                                                        break;
                                                    case 1:
                                                        $statusText = 'Sedang Dikirim';
                                                        break;
                                                    case 2:
                                                        $statusText = 'Sudah Diterima';
                                                        break;
                                                    case 3:
                                                        $statusText = 'Dibatalkan';
                                                        break;
                                                    default:
                                                        $statusText = 'Status Tidak Valid';
                                                }
                                            @endphp
                                            <div class="badge rounded-pill bg-light-info text-info w-100">
                                                {{ $statusText }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex order-actions">
                                                <a href="javascript:;" class=""><i class="bx bx-cog"></i></a>
                                                <a href="{{ route('cetakInvoiceStaff', ['orderId' => $order->order_id]) }}" class="ms-4">
                                                    <i class="bx bx-down-arrow-alt"></i>
                                                </a>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!--end page wrapper -->
@endsection
