@extends('frontend.master_dashboard')
@section('main')
    @php
        use Illuminate\Support\Facades\Route;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\Session;
    @endphp

    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="ps-3">
            </div>
            <div class="ms-auto">

            </div>
        </div>
        <!--end breadcrumb-->

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="table-container">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total</th>
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
                                                        <img src="{{ asset('upload/product/' . $orderItem->product->image1) }}"
                                                            alt="" />
                                                    </div>
                                                    <div class="ms-2">
                                                        <h6 class="mb-1 font-14">{{ $orderItem->product->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
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
                                                <div class="badge rounded-pill bg-light-info text-info w-150">
                                                    {{ $statusText }}
                                                </div>
                                            </td>
                                            <td>

                                                {{-- @php
                                                $paymentStatus = $order->hasPaymentProof();
                                            @endphp

                                            @if ($paymentStatus === 'upload') --}}
                                                {{-- <button type="button" class="btn btn-primary btn-sm" onclick="showUploadForm('{{ $order->order_id }}')">Upload Bukti Bayar</button>
                                                <form id="uploadForm_{{ $order->order_id }}" action="{{ route('uploadPaymentProof', ['orderId' => $order->order_id]) }}" method="POST" enctype="multipart/form-data" style="display: none;">
                                                    @csrf
                                                    <input type="file" name="bukti_bayar" accept="image/*">
                                                    <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                                                </form> --}}
                                            {{-- @elseif ($paymentStatus === 'invoice') --}}
                                                <a href="{{ route('cetakInvoice', ['orderId' => $order->order_id]) }}" class="btn btn-primary btn-sm">Cetak Invoice</a>
                                            {{-- @endif --}}



                                            </td>

                                            <script>
                                                function showUploadForm(orderId) {
                                                    // Menampilkan form upload dengan mengubah display style menjadi block
                                                    document.getElementById('uploadForm_' + orderId).style.display = 'block';
                                                }
                                            </script>


                                        </tr>

                                    @endforeach
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Kode Pembelian</th>
                                    <th>Nama Produk</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>



    </div>
@endsection
