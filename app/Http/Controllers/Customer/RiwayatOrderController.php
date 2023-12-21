<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatOrderController extends Controller
{
    //endpoint menampilkan riwayat pesanan
    public function RiwayatOrderCustomer()
    {
        $user = Auth::user();
        $riwayatPesanan = Orders::where('user_id', $user->id)
            ->with(['orderItems.product', 'payments', 'testimoniProduk']) // Make sure relationships are defined in Orders model
            ->get();
        return view('frontend.order.riwayatOrder', compact('riwayatPesanan'));
    }

    //endpoint konfirmasi terima pesanan
    public function updateStatus(Request $request)
{
    $orderId = $request->input('orderId');
    $newStatus = $request->input('newStatus');

    // Update the order status in the database
    $order = Orders::find($orderId);
    if (!$order) {
        return response()->json(['error' => 'Order not found'], 404);
    }

    $order->status = $newStatus;
    $order->save();

    // You can also return a success response here if needed
    return response()->json(['message' => 'Status updated successfully']);
}



    //endpoint untuk input testimoni produk
    public function StoreTestimoniProduk(Request $request)
    {
        // Validate the input
        $request->validate([
            'product_id' => 'required',
            'rating' => 'required', // Adjust validation rules as needed
            'comment' => 'required',
        ]);

        try {
            // Create a new ProductReview instance
            $review = new ProductReview();

            // Fill the review data
            $review->product_id = $request->input('product_id');
            $review->user_id = auth()->user()->id;
            $review->rating = $request->input('rating');
            $review->comment = $request->input('comment');

            // Save the review to the database
            $review->save();

            // Return a success response
            $notification = array(
                'message' => 'Testimoni Produk berhasil ditambahkan',
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

        } catch (\Exception $e) {
            // Return an error response in case of an exception
            $notification = array(
                'message' => 'Terjadi kesalahan saat menambahkan testimoni produk.',
                'alert-type' => 'error'
            );

            return redirect()->back()->with($notification);
        }
    }
}
