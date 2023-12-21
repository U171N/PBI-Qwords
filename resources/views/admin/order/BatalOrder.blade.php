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
            <div class="breadcrumb-title pe-3">Data Pesanan Dibatalkan</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
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
                                @if ($order->status == 3)
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
                                                <a href="" class="ms-4">
                                                    <i class="bx bx-down-arrow-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                                <tr>
                                                    <td>#</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="recent-product-img">
                                                                <img src="" alt="not found" />
                                                            </div>
                                                            <div class="ms-2">
                                                                <h6 class="mb-1 font-14"></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <div class="badge rounded-pill bg-light-info text-info w-100">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex order-actions">
                                                            <a href="javascript:;" class=""><i class="bx bx-cog"></i></a>
                                                            <a href="{{ route('cetakInvoiceAdmin', ['orderId' => $order->order_id]) }}" class="ms-4">
                                                                <i class="bx bx-down-arrow-alt"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>
@endsection
