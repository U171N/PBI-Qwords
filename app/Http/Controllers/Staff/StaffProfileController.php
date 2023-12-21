<?php

namespace App\Http\Controllers\Staff;

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

class StaffProfileController extends Controller
{
    //menampilkan halaman dashboard pada user staff
    public function StaffDashboard(){
        $totalRevenue = Orders::where('status', 2)
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->sum('order_items.price');

        $totalSoldProducts = Orders::where('status', 2)
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->sum('order_items.quantity');

        $totalCustomer = User::where('role', 'customer')->count();

        $reviews = ProductReview::all();

        $orders =Orders::with(['orderItems.product','user'])->get();

        return view('staff.index', [
            'totalRevenue' => $totalRevenue,
            'totalSoldProducts' => $totalSoldProducts,
            'totalCustomer' => $totalCustomer,
            'reviews'=>$reviews,
            'orders' => $orders
        ]);
    }

    //menampilkan halaman login untuk para staff
    public function StaffLogin(){
        return view('staff.staff_login');
    }

    //endpoint menampilkan data review product dari customer
    public function showProductReview(){
        $reviews = ProductReview::all();
        return view('staff.review', ['reviews2' => $reviews]);
    }


    //endpoint cetak invoice pelanggan
    public function cetakInvoiceStaff($orderId) {
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
        $html = view('staff.invoiceStaff', $data)->render();

        $pdf = app()->make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option('isHtml5ParserEnabled', true); // Enable HTML5 parser
        $pdf->getDomPDF()->set_option('isPhpEnabled', false); // Disable PHP script execution (if not needed)
        $pdf->getDomPDF()->set_option('isRemoteEnabled', false); // Disable remote file access (if not needed)
        $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', true); // Enable font subsetting

        $pdf->loadHTML($html);

        return $pdf->stream('invoice_' . $order->order_id . '.pdf', ['Content-Type' => 'application/pdf']);

    }

    //endpoint untuk menampilkan halaman edit profile staff
    public function StaffProfile(){
        $id = Auth::user()->id;
        $staffData = User::find($id);
        return view('staff.staff_profile',compact('staffData'));
    }

    //endpoint untuk melakukan aksi update data profile staff
    public function StaffProfileStore(Request $request){
        $id =Auth::user()->id;
        $data = User::find($id);
        $data->name =$request->name;
        $data->email =$request->email;
        $data->phone =$request->phone;
        $data->address =$request->address;
        $data->department =$request->department;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/staff_images/'.$data->photo));
            $extension = $file->getClientOriginalExtension();
            $filename =$id . '-' . Str::slug($request->name,'-').'-'.date('YmdHis').'.'.$extension;
            $file->move(public_path('upload/staff_images/'),$filename);
            $data->photo = $filename;
        }
        $data->save();

        $notification =array(
            'message'=>'Update Profile Berhasil',
            'alert-type' => 'success',
        );

        return redirect()->back()->with($notification);
    }

    //menampilkan halaman update password
    public function StaffChangedPassword(){
        return view('staff.staff_change_password');
    }

    //endpoint untuk update password
    public function StaffUpdatePassword(Request $request){
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
            'password'=>Hash::make($request->new_password)
        ]);

        return back()->with("status","Update Password Berhasil");
    }

    //endpoint logout staff

    public function StaffDestroy(Request $request) {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/staff/login');
    }
}
