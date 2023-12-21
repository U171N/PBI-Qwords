<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use App\Models\Products;
use App\Models\Province;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Kodepandai\LaravelRajaOngkir\Facades\RajaOngkir;

class CartController extends Controller
{
    //endpoint menambahkan data kedalam keranjang belanja
    public function AddToCart(Request $request,$id){
        if(Session::has('coupon')){
            Session::forget('coupon');
        }
        $product = Products::findOrFail($id);

        if($product->discount_price==NULL){
            Cart::add([
                'id'=>$id,
                'name'=>$request->product_name,
                'qty'=>$request->quantity,
                'price'=>$product->price,
                'weight'=>$product->product_weight,
                'options'=>[
                    'image1'=>$product->image1,
                    'color'=>$request->color,
                    'size'=>$request->size
                ],
            ]);

            return response()->json(['success'=>'Produk berhasil ditambahkan kedalam Keranjang Belanja']);
        }else{
            Cart::add([
                'id' => $id,
                'name' => $request->product_name,
                'qty' => $request->quantity,
                'price' => $product->discount_price,
                'weight' => $product->product_weight,
                'options' => [
                    'image1' => $product->image1,
                    'color' => $request->color,
                    'size' => $request->size,
                ],
            ]);
            return response()->json(['success'=>'Produk berhasil ditambahkan kedalam Keranjang Belanja']);
        }
    }

    //endpoint detail produk pada keranjang belanja
    public function AddToCartDetails(Request $request, $id) {
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }
        $product = Products::findOrFail($id);

        if ($product->discount_price === null) {
            $price = $product->price;
        } else {
            $price = $product->discount_price;
        }
        $totalWeight = $product->product_weight * $request->quantity;

        Cart::add([
            'id' => $id, // Use 'id' instead of 'product_id'
            'name' => $product->name, // Use the actual product name
            'qty' => $request->quantity,
            'price' => $price,
            'weight' => $totalWeight,
            'options' => [
                'image1' => $product->image1,
                'color' => $request->product_color, // Use the correct attribute
                'size' => $request->product_size, // Use the correct attribute
            ],
        ]);

        return response()->json(['success' => 'Product successfully added to the cart']);
    }


    //endpoint menambahkan data kedalam mini cart

    public function AddMiniCart(){

        $carts = Cart::content();
        $cartQty=Cart::count();
        $cartTotal=Cart::total();

        return response()->json(array(
            'carts'=>$carts,
            'cartQty'=>$cartQty,
            'cartTotal'=>$cartTotal
        ));
    }

    //endpoint remove data didalam mini cart
    public function RemoveMiniCart($rowId){
        Cart::remove($rowId);
        return response()->json(['success'=>'Item berhasil dihapus']);
    }

    //endpoint menampilkan halaman cart
    public function MyCart(){
        return view('frontend.mycart.view_mycart');
    }

    //endpoint get data produk pada Keranjang belanja
    public function GetCartProduct(){
        $carts = Cart::content();
        $cartQty= Cart::count();
        $cartTotal = Cart::total();

        return response()->json(array(
            'carts'=>$carts,
            'cartQty'=>$cartQty,
            'cartTotal'=>$cartTotal
        ));
    }



    //endpoint untukmenghapus data di session Keranjang belanja
    public function CartRemove($rowId){
        Cart::remove($rowId);

        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['code'];
            $coupon = Coupons::where('code',$coupon_name)->first();

            Session::put('coupon',[
                'code'=>$coupon->code,
                'discount'=>$coupon->discount,
                'discount_amount' => round(Cart::total() * $coupon->discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->discount/100 )
            ]);
        }

        return response()->json(['success'=>'berhasil menghapus dari daftar belanja']);
    }


    //endpoint untuk  mengurangi daftar keranjang belanja secara berkesinambungan
    public function CartDecrement($rowId){
        $row = Cart::get($rowId);
        $product = Products::findOrFail($row->id); // Use the correct field to identify the product
        $totalWeight = $product->product_weight / $row->qty ;

        Cart::update($rowId,$row->qty - 1);
        $product->update(['product_weight' => $totalWeight]);

        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['code'];
            $coupon = Coupons::where('code',$coupon_name)->first();

            Session::put('coupon',[
                'code'=>$coupon->code,
                'discount'=>$coupon->discount,
                'discount_amount' => round(Cart::total() * $coupon->discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->discount/100 )
            ]);
        }

        return response()->json('Decrement');
    }

    //endpoint untuk menambahkan daftar keranjang belanja secara otomatis
    public function CartIncrement($rowId) {
        $row =Cart::get($rowId);
        $product = Products::findOrFail($row->id); // Use the correct field to identify the product
        $totalWeight = $product->product_weight * ($row->qty + 1);

        Cart::update($rowId,$row->qty + 1);
        $product->update(['product_weight' => $totalWeight]);

        if(Session::has('coupon')){
            $coupon_name = Session::get('coupon')['code'];
            $coupon = Coupons::where('code',$coupon_name)->first();
            Session::put('coupon',[
                'code'=>$coupon->code,
                'discount'=>$coupon->discount,
                'discount_amount' => round(Cart::total() * $coupon->discount/100),
                'total_amount' => round(Cart::total() - Cart::total() * $coupon->discount/100 )
            ]);
        }

        return response()->json('Increment');
    }

    //endpoint untuk mengaktifkan fitur kupon pada keranjang belanja
    // public function CouponApply(Request $request){
    //     $couponCode = $request->input('code');
    //     $coupon = Coupons::where('code', $couponCode)
    //         ->where('valid_from', '<=', Carbon::now())
    //         ->where('valid_to', '>=', Carbon::now())
    //         ->first();

    //     if ($coupon) {
    //         // Make sure to cast the discount to an integer
    //         $discount = (int) $coupon->discount;

    //         // Get the subtotal from the cart and ensure it's numeric
    //         $subtotal = Cart::total();
    //         // Remove any non-numeric characters
    //         $subtotal = preg_replace("/[^0-9.]/", "", $subtotal);

    //         $subtotal = (int) $subtotal;
    //         if (!is_numeric($subtotal)) {
    //             return response()->json(['validity' => false, 'error' => 'Invalid subtotal']);
    //         }

    //         // Ensure the discount is numeric
    //         if (!is_numeric($discount)) {
    //             return response()->json(['validity' => false, 'error' => 'Invalid discount']);
    //         }

    //         // Calculate discount amount and total amount
    //         $discountAmount = round($subtotal * $discount / 100);
    //         $totalAmount = round($subtotal - $discountAmount);

    //         Session::put('coupon', [
    //             'code' => $coupon->code,
    //             'discount' => $discount,
    //             'discount_amount' => $discountAmount,
    //             'total_amount' => $totalAmount,
    //         ]);

    //         return response()->json([
    //             'validity' => true,
    //             'success' => 'Kupon berhasil dipakai'
    //         ]);
    //     } else {
    //         return response()->json(['validity' => false, 'error' => 'Kupon Salah']);
    //     }
    // }

    public function CouponApply(Request $request){
        $couponCode = $request->input('code');
        $coupon = Coupons::where('code', $couponCode)
            ->where('valid_from', '<=', Carbon::now())
            ->where('valid_to', '>=', Carbon::now())
            ->first();

        if ($coupon) {
            $discount = (int) $coupon->discount;

            // Get the cart total and ensure it's numeric
            $subtotal = Cart::total();
            $subtotal = preg_replace("/[^0-9.]/", "", $subtotal);
            $subtotal = (int) $subtotal;

            if (!is_numeric($subtotal)) {
                return response()->json(['validity' => false, 'error' => 'Invalid subtotal']);
            }

            if (!is_numeric($discount)) {
                return response()->json(['validity' => false, 'error' => 'Invalid discount']);
            }

            $discountAmount = round($subtotal * $discount / 100);
            $totalAmount = round($subtotal - $discountAmount);

            Session::put('coupon', [
                'code' => $coupon->code,
                'discount' => $discount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
            ]);

            return response()->json([
                'validity' => true,
                'success' => 'Coupon applied successfully'
            ]);
        } else {
            return response()->json(['validity' => false, 'error' => 'Invalid coupon']);
        }
    }

    //endpoint untuk kalkulasi keselurahan setelah apply kupon

    public function CouponCalculation(){
        if (Session::has('coupon')) {
            $coupon = session()->get('coupon');
            $subtotal = Cart::total();
            $discountAmount = $coupon['discount_amount'];
            $totalAmount = $coupon['total_amount'];

            return response()->json([
                'subtotal' => $subtotal,
                'discount' => $coupon['discount'],
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
            ]);
        } else {
            return response()->json([
                'subtotal' => Cart::total(),
            ]);
        }
    }


    //endpoint untuk menghapus data di Keranjang Belanja
    public function CouponRemove(){
        Session::forget('coupon');
        return response()->json(['success'=>'Kupon berhasil dihapus']);
    }

    //endpoint masuk menu checkout
    public function CheckoutCreate(){

        if (Auth::check()) {

            if (Cart::total() > 0) {

        $carts = Cart::content();
        $cartQty = Cart::count();
        $cartTotal = Cart::total();


        $divisions = Province::orderBy('name','ASC')->get();

        $products = Products::latest()->get();

        return view('frontend.checkout.checkout_view',compact('carts','cartQty','cartTotal','divisions','products'));


            }else{

            $notification = array(
            'message' => 'Shopping At list One Product',
            'alert-type' => 'error'
        );

        return redirect()->to('/')->with($notification);
            }



        }else{

             $notification = array(
            'message' => 'Login Terlebih Dahulu',
            'alert-type' => 'error'
        );

        return redirect()->route('login')->with($notification);
        }
    }
}
