<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Coupons;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    //function untuk menampikan semua data coupon
    public function AllCoupon(){
        $coupon = Coupons::latest()->get();
        return view('staff.coupon.coupon_all',compact('coupon'));
    }

    //function untuk menampilkan halaman tambah data coupon
    public function AddCoupon(){
        return view('staff.coupon.coupon_add');
    }

    //endpoint untuk melakukan aksi tambah data coupon
    public function StoreCoupon(Request $request){
        // $formattedSellingPrice = number_format((float) $request->coupon_discount, 2, '.', '');

        Coupons::insert([
            'code'=>strtoupper($request->coupon_name),
            'discount'=>$request->coupon_discount,
            'valid_from'=>$request->coupon_from,
            'valid_to'=>$request->coupon_to,
            'created_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message'=>'Kupon berhasil dibuat',
            'alert-type'=>'success',
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    //function untuk menampilkan edit data coupon
    public function EditCoupon($id){
        $coupon = Coupons::findOrFail($id);
        return view('staff.coupon.edit_coupon',compact('coupon'));
    }

    //endpoint untuk melakukan Update data coupon
    public function UpdateCoupon(Request $request){
        $coupon_id = $request->id;
        // $formattedSellingPrice = number_format((float) $request->coupon_discount, 2, '.', '');

        Coupons::findOrFail($coupon_id)->update([
            'code'=>strtoupper($request->coupon_name),
            'discount'=>$request->coupon_discount,
            'valid_from'=>$request->coupon_from,
            'valid_to'=>$request->coupon_to,
            'updated_at'=>Carbon::now(),
        ]);

        $notification = array(
            'message'=>'Data kupon berhasil di Update',
            'alert-type'=>'success',
        );

        return redirect()->route('all.coupon')->with($notification);
    }

    //endpoint untuk hapus data coupon
    public function DeleteCoupon($id){
        Coupons::findOrFail($id)->delete();

        $notification=array(
            'message'=>'data kupon berhasil dihapus',
            'alert-type'=>'success'
        );

        return redirect()->back()->with($notification);
    }
}
