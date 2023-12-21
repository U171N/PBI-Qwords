<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OrderPayment;
use App\Models\Orders;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\Facades\Image;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{

    //menampilakn data order Customer
    public function orderCustomer(){
        $user = Auth::user();

        $orders = Orders::where('user_id', $user->id)
    ->with(['orderItems.product', 'payments'])
    ->get();

return view('frontend.order.order_details', compact('orders'));

        return view('frontend.order.order_details', compact('orders'));
    }

    //endpoint upload bukti pembayaran
    public function uploadPaymentProof($orderId)
    {
        $order = Orders::where('order_id', $orderId)->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Data order tidak ditemukan');
        }

        // Temukan entri pembayaran yang ada (jika sudah ada)
        $payment = OrderPayment::where('order_id', $order->order_id)->first();

        // Jika belum ada entri pembayaran, buat satu
        if (!$payment) {
            $payment = new OrderPayment();
            $payment->order_id = $order->order_id;
            // $payment->payment_method_id = $order->payment->payment_method_id;
            $payment->status_pembayaran = 0; // Atur status pembayaran sesuai kebutuhan
        }

        // Upload bukti pembayaran
        if (request()->hasFile('bukti_bayar')) {
            $file = request()->file('bukti_bayar');

            // Initialize the file name
            $fileName = 'bukti_bayar-' . $order->order_id . '.' . $file->getClientOriginalExtension();

            // Save the file to the storage location
            $filePath = 'upload/bukti-bayar/' . $fileName;
            Image::make($file)->resize(120, 120)->save(public_path($filePath));

            // Perbarui informasi bukti pembayaran
            $payment->bukti_bayar = $fileName;
            $payment->save();

            $notification = [
                'message' => 'Upload bukti pembayaran berhasil',
                'alert-type' => 'success',
            ];
            // return response()->json(['success' => true, 'message' => 'Upload bukti pembayaran berhasil']);

        } else {
            // return response()->json(['success' => false, 'message' => 'Upload bukti pembayaran gagal']);

            $notification = [
                'message' => 'Upload bukti pembayaran gagal',
                'alert-type' => 'error',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function checkPaymentProof($orderId)
{
    $order = Orders::findOrFail($orderId);
    return $order->payments->isNotEmpty(); // Assuming payments is the relationship for payment proofs

}


    //endpoint cetak pdf customer
    public function cetakInvoice($orderId) {
        $order = Orders::with(['orderItems.product', 'payments','paymentMethods', 'pengirimens'])
        ->where('order_id', $orderId)
        ->first();



        // dd($order);
    if (!$order) {
        return redirect()->back()->with('error', 'Order not found.');
    }

        // Check if the payment relationship exists and if bukti_bayar exists
        if ($order->payment && $order->payment->bukti_bayar !== null) {
            return redirect()->back()->with('error', 'Payment proof is required to print the invoice.');
        }

        // Load view dalam bentuk html
        $data = ['order' => $order];
        $html = view('frontend.invoice', $data)->render();

        $pdf = app()->make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $pdf->getDomPDF()->set_option('isPhpEnabled', false); // Disable PHP script execution (if not needed)
        $pdf->getDomPDF()->set_option('isRemoteEnabled', false); // Disable remote file access (if not needed)
        $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', true); // Enable font subsetting

        $pdf->loadHTML($html);

        return $pdf->stream('invoice_' . $order->order_id . '.pdf');
    }

/*Kelola Order pada user Staff */

    //endpoint pending order pada user staff
    public function pendingOrderStaff(){
        $orders = Orders::with(['orderItems.product', 'payments', 'pengirimens','user'])
        ->where('status', 0)
        ->get();
        return view('staff.order.prosesOrder',compact('orders'));
    }

    //endpoint pesanan dikirim pada user staff
    public function orderDikirimStaff(){
        $orders = Orders::with(['orderItems.product', 'payments', 'pengirimens','user'])
        ->where('status', 1)
        ->get();
        return view('staff.order.KirimOrder',compact('orders'));
    }

    //endpoint pesanan selesai pada user staff
    public function orderSelesaiStaff(){
        $orders = Orders::with(['orderItems.product','payments','pengirimen','user'])
        ->where('status',2)
        ->get();
        return view('staff.order.selesaiOrder',compact('orders'));
    }

    //endpoint pesanan dibatalkan pada user staff
    public function orderCancelStaff(){
        $orders = Orders::with(['orderItems.product','payments','pengirimens','user'])
        ->where('status',3)
        ->get();
        return view('staff.order.BatalOrder',compact('orders'));
    }


    //endpoint untuk verfikasi status order pada user staff
public function updateOrderStatusStaff(Request $request) {
    $orderId = $request->input('orderId');
    $newStatus = $request->input('orderStatus');

    // Find the order associated with the payment
    $order = Orders::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Update the order status
    $order->status = $newStatus;
    $order->save();

    return response()->json(['message' => 'Order status updated successfully']);
}


    //endpoint untuk verifikasi status pembayaran pada user staff
    public function updatePaymentStatusStaff(Request $request) {
        $orderId = $request->input('orderId');
        $newPaymentStatus = $request->input('paymentStatus');

        // Find the order associated with the payment
        $order = Orders::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Find the payments associated with the order
        $payments = $order->payments;

        if ($payments->isEmpty()) {
            return response()->json(['message' => 'Order payment not found'], 404);
        }

        // Update the payment status for each payment
        foreach ($payments as $payment) {
            $payment->status_pembayaran = $newPaymentStatus;
            $payment->save();
        }

        return response()->json(['message' => 'Payment status updated successfully']);
    }






    /*Kelola Order pada bagian user ADMIN */

     //endpoint pending order pada user admin
     public function pendingOrderAdmin(){
        $orders = Orders::with(['orderItems.product', 'payments', 'pengirimens','user'])
        ->where('status', 0)
        ->get();
        return view('admin.order.prosesOrder',compact('orders'));
    }

    //endpoint pesanan dikirim pada user admin
    public function orderDikirimAdmin(){
        $orders = Orders::with(['orderItems.product', 'payments', 'pengirimens','user'])
        ->where('status', 1)
        ->get();
        return view('admin.order.KirimOrder',compact('orders'));
    }

    //endpoint pesanan selesai pada user admin
    public function orderSelesaiAdmin(){
        $orders = Orders::with(['orderItems.product','payments','pengirimens','user'])
        ->where('status',2)
        ->get();
        return view('admin.order.selesaiOrder',compact('orders'));
    }

    //endpoint pesanan dibatalkan pada user admin
    public function orderCancelAdmin(){
        $orders = Orders::with(['orderItems.product','payments','pengirimens','user'])
        ->where('status',3)
        ->get();
        return view('admin.order.BatalOrder',compact('orders'));
    }


     //endpoint untuk verfikasi status order pada user Admin
public function updateOrderStatusAdmin(Request $request) {
    $orderId = $request->input('orderId');
    $newStatus = $request->input('orderStatus');

    // Find the order associated with the payment
    $order = Orders::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Update the order status
    $order->status = $newStatus;
    $order->save();

    return response()->json(['message' => 'Order status updated successfully']);
}


    //endpoint untuk verifikasi status pembayaran pada user Admin
    public function updatePaymentStatusAdmin(Request $request) {
        $orderId = $request->input('orderId');
        $newPaymentStatus = $request->input('paymentStatus');

        // Find the order associated with the payment
        $order = Orders::where('order_id', $orderId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Find the payments associated with the order
        $payments = $order->payments;

        if ($payments->isEmpty()) {
            return response()->json(['message' => 'Order payment not found'], 404);
        }

        // Update the payment status for each payment
        foreach ($payments as $payment) {
            $payment->status_pembayaran = $newPaymentStatus;
            $payment->save();
        }

        return response()->json(['message' => 'Payment status updated successfully']);
    }

}
