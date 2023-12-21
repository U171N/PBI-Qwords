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
            <div class="breadcrumb-title pe-3">Data Pesanan sedang Diproses</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}"><i class="bx bx-home-alt"></i></a>
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
                    <table id="example" class="table align-middle mb-0">
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
                                    @if ($order->status == 0)
                                        <tr>
                                            <td>#{{ $order->order_id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="recent-product-img">
                                                        <img src="{{ asset('upload/product/' . $orderItem->product->image1) }}"
                                                            alt="" />
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
                                                    <a href="javascript:;" class="update-status" data-status-type="payment"
                                                        data-order-id="{{ $order->order_id }}" data-toggle="modal"
                                                        data-target="#updateStatusModal">
                                                        <i class="bx bx-cog"></i>
                                                    </a>
                                                    </a>
                                                    <a href="{{ route('cetakInvoiceStaff', ['orderId' => $order->order_id]) }}"
                                                        class="ms-4">
                                                        <i class="bx bx-down-arrow-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Modal -->
                                        <div class="modal fade" id="updateStatusModal" tabindex="-1"
                                            aria-labelledby="updateStatusModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateStatusModalLabel">Update Status
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul class="nav nav-tabs" id="statusTabs" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link active" id="orderStatusTab"
                                                                    data-bs-toggle="tab" href="#orderStatus" role="tab"
                                                                    aria-controls="orderStatus" aria-selected="true">Order
                                                                    Status</a>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <a class="nav-link" id="paymentStatusTab"
                                                                    data-bs-toggle="tab" href="#paymentStatus"
                                                                    role="tab" aria-controls="paymentStatus"
                                                                    aria-selected="false">Payment Status</a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="statusTabContent">
                                                            <div class="tab-pane fade show active" id="orderStatus"
                                                                role="tabpanel" aria-labelledby="orderStatusTab">
                                                                <form id="updateOrderStatusForm"
                                                                    action="{{ route('updateStatusOrder.staff') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" id="modalOrderId_order"
                                                                        name="orderId" value="{{ $order->order_id }}">
                                                                    <div class="mb-3">
                                                                        <label for="orderStatus_order"
                                                                            class="form-label">New Order Status</label>
                                                                        <select class="form-select" id="orderStatus_order"
                                                                            name="orderStatus">
                                                                            <option value="1">Sedang Dikirim</option>
                                                                            <option value="3">Dibatalkan</option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Update
                                                                        Order Status</button>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane fade" id="paymentStatus" role="tabpanel"
                                                                aria-labelledby="updateStatusModalLabel">
                                                                <form id="updatePaymentStatusForm"
                                                                    action="{{ route('updateStatusPayment.staff') }}"
                                                                    method="POST">
                                                                    @csrf

                                                                    <input type="hidden" id="modalOrderId_payment"
                                                                        name="orderId">
                                                                    <div class="mb-3">
                                                                        <label for="paymentStatus_payment"
                                                                            class="form-label">New Payment Status</label>
                                                                        <select class="form-select"
                                                                            id="paymentStatus_payment"
                                                                            name="paymentStatus">
                                                                            <option value="1">Sudah Dibayar</option>
                                                                            <option value="2">Pembayaran Ditolak
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Update
                                                                        Payment Status</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <a href="" class="ms-4">
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
