<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Models\ProductReview;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{
    //menampilkan halaman dashboard admin
    public function AdminDashboard() {
        $totalRevenue = Orders::where('status', 2)
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->sum('order_items.price');

        $totalSoldProducts = Orders::where('status', 2)
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->sum('order_items.quantity');

        $totalCustomer = User::where('role', 'customer')->count();

        $reviews = ProductReview::all();


        $orders =Orders::with(['orderItems.product','user'])->get();

        return view('admin.index', [
            'totalRevenue' => $totalRevenue,
            'totalSoldProducts' => $totalSoldProducts,
            'totalCustomer' => $totalCustomer,
            'reviews'=>$reviews,
            'orders' => $orders

        ]);
    }


    //endpoint menampilkan hasil review penjualan produk
    public function showProductReview(){
        $reviews = ProductReview::all();
        return view('admin.review', ['reviews' => $reviews]);

    }

    //endpoint cetak pdf
    public function cetakInvoiceAdmin($orderId) {
        $order = Orders::with(['orderItems.product', 'payments', 'pengirimens','user'])
            ->where('order_id', $orderId)
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        // pengecekan apakah barang sudah dibayar atau belum
       if ($order->payment && $order->payment->bukti_bayar !== null) {
        return redirect()->back()->with('error', 'Payment proof is required to print the invoice.');
    }

        // Load view dalam bentuk html
        $data = ['order' => $order];
        $html = view('admin.invoiceAdmin', $data)->render();

        $pdf = app()->make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $pdf->getDomPDF()->set_option('isPhpEnabled', false); // Disable PHP script execution (if not needed)
        $pdf->getDomPDF()->set_option('isRemoteEnabled', false); // Disable remote file access (if not needed)
        $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', true); // Enable font subsetting

        $pdf->loadHTML($html);

        return $pdf->stream('invoice_' . $order->order_id . '.pdf', ['Content-Type' => 'application/pdf']);

    }


    //menampilkan halaman login pada admin
    public function AdminLogin(){
        return view('admin.admin_login');
    }

    //menampilkan profile admin
    public function AdminProfile(){
        $id = Auth::user()->id;
        $adminData =User::find($id);
        return view('admin.admin_profile',compact('adminData'));
    }

    //endpoint update profile
    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
        @unlink(public_path('upload/admin_images/'.$data->photo));
        $extension = $file->getClientOriginalExtension();
        $filename = $id . '-' . Str::slug($request->name, '-') . '-' . date('YmdHis') . '.' . $extension;
        $file->move(public_path('upload/admin_images'), $filename);
        $data->photo = $filename;
        }
        $data->save();

        $notification = array(
            'message'=>'Update Profile Berhasil',
            'alert-type'=>'success',
        );
        return redirect()->back()->with($notification);
    }

    //endpoint menampilkan halaman update password
    public function AdminChangePassword(){
        return view('admin.admin_change_password');
    }

    //endpoint untuk update password
    public function AdminUpdatePassword(Request $request){
        $request->validate([
            'old_password'=>'required',
            'new_password'=>'required|confirmed',
        ]);

        //mencocokan password
         if(!Hash::check($request->old_password,auth::user()->password)){
            return back()->with("error","Password tidak sama");
         }

         //update password baru
         User::whereId(auth()->user()->id)->update([
            'password' =>Hash::make($request->new_password)
         ]);

         return back()->with("status","Update Password Berhasil");
    }
    //endpoint ketika logout
    public function AdminDestroy(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login'); //ketika menggunakan redirect maka yang dicantumkan alamat dari route bukan dari views
    }
}
