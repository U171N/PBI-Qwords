<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\OrderPayment;
use App\Models\Orders;
use App\Models\PaymentMethod;
use App\Models\Pengiriman;
use App\Models\Products;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

use Midtrans\Config;
use Midtrans\Snap;


class CheckoutController extends Controller
{

    // public function __construct(){
    //     parent::__construct();

    //     //memuat library midtrans
    //     require_once dirname(__FILE__) . '/../../Midtrans.php';

    //     //setting configure midtrans
    //     Config::$serverKey ="SB-Mid-server-6yRH0st2uEeYV0ZgW_8MHzXU";

    //     Config::$isSanitized = Config::$is3ds=true;
    // }


    public function calculateShippingCost(Request $request)
    {
        $item_details = [];
        $productPrice = 0; // Inisialisasi total harga produk
        foreach (Cart::content() as $cartItem) {
            $item_details[] = [
                'id' => $cartItem->id,
                'price' => (float) $cartItem->price,
                'quantity' => $cartItem->qty,
                'name' => $cartItem->name,
            ];
            $productPrice += (float) $cartItem->price;
        }

        try {
            $weight = $request->weight;
            $packageType = $request->paket;

            // Define cost per 1000 grams based on the package type
            $costPer1000Grams = ($packageType === 'regular') ? 20000 : 60000;

            // Calculate the shipping cost as 10% of the product price
            $shippingCost = $productPrice * 0.1;

            // Add the cost based on weight and package type
            $shippingCost += ($weight / 1000) * $costPer1000Grams;

            // Check if package type is "express" and reduce $15000
            if ($packageType === 'express' && $weight >= 1000) {
                $shippingCost -= 25000;
            }

            return response()->json([
                'success' => true,
                'shipping_cost' => $shippingCost,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'shipping_cost' => 0,
            ]);
        }
    }





    //endpoint menghitung ongkir Raja Ongkir
    public function calculateShippingCost2($weight, $packageType)
    {
        // try {
        //     $response = Http::withOptions(['verify' => false])->withHeaders([
        //         'key' => env('RAJAONGKIR_API_KEY')
        //     ])->post('https://api.rajaongkir.com/' . env('RAJAONGKIR_TYPE') . '/cost', [
        //         'origin' => $request->origin,
        //         'destination' => $request->destination,
        //         'weight' => $request->weight,
        //         'courier' => $request->courier
        //     ])->json();

        //     if (isset($response['rajaongkir']['status']['code']) && $response['rajaongkir']['status']['code'] === 200) {
        //         return response()->json([
        //             'success' => true,
        //             'data' => $response['rajaongkir']['results'][0]['costs'],
        //         ]);
        //     } else {
        //         return response()->json([
        //             'success' => false,
        //             'message' => 'Invalid API Response Structure',
        //             'data'    => []
        //         ]);
        //     }
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => $th->getMessage(),
        //         'data'    => []
        //     ]);
        // }

        // $weight = $request->weight;
        // $packageType = $request->paket;


        try {
            // Define cost per 1000 grams based on the package type
            $costPer1000Grams = ($packageType === 'regular') ? 20000 : 60000;

            // Calculate the shipping cost
            $shippingCost = ($weight / 1000) * $costPer1000Grams;

            // Calculate 10% tax on the shipping cost
            $taxAmount = $shippingCost * 0.1;

            // Calculate the final shipping cost with tax
            $shippingCostWithTax = $shippingCost + $taxAmount;

            return $shippingCostWithTax;
        } catch (\Throwable $th) {
            return $shippingCost; // Return 0 or handle the error
        }

    }




    //endpoint untuk mendapatkan data provinsi
    public function ProvinceGetAjax($province_id)
    {
        $ship = Regency::where(
            'province_id',
            $province_id
        )->orderBy('name', 'ASC')->get();
        return json_encode($ship);
    }

    //endpoint untuk mendapatkan data daerah kota
    public function RegenciesGetAjax($regencies_id)
    {
        $ship = Village::where('district_id', $regencies_id)->orderBy('name', 'ASC')->get();
        return json_encode($ship);
    }

    //endpoint untuk melakukan aksi checkout barang
    public function CheckoutStore(Request $request)
    {
        // $newOrder = new Orders();
        // $newOrder->order_id = Orders::generateCustomeId();

        $data = array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['postal_code'] = $request->post_code;

        $data['province'] = $request->division_id;
        $data['city'] = $request->district_id;
        // $data['city'] = $request->state_id;
        $data['shipping_address'] = $request->shipping_address;
        $data['notes'] = $request->notes;
        $cartTotal = Cart::total();

        // //memasukan data ongkir kedalam pengiriman

        // $weight = $request->weight;
        // $packageType = $request->paket;
        // $shippingCost = $this->calculateShippingCost2($weight, $packageType);

        // Make sure $shippingCost is numeric and not null before insertion
        // if (!is_numeric($shippingCost)) {
        //     return response()->json(['error' => 'Invalid shipping cost'], 400);
        // }

        // Return the inserted record or a success response
        // return response()->json(['message' => 'Record inserted successfully', 'data' => $insertedRecord], 201);


        // $item_details2 = [];
        // foreach (Cart::content() as $cartItem) {
        //     $item_details2[] = [
        //         'id' => $cartItem->id,
        //         'price' => (int) $cartItem->price,
        //         'quantity' => $cartItem->qty,
        //         'name' => $cartItem->name,
        //     ];
        // }

        // $transaction_details = array(
        //     'order_id' => rand(),
        //     'gross_amount' => (float)$cartTotal + (float)$request->hidden_shipping_cost + (float)$cartItem->tax,
        // );

        // $customer_details = array(
        //     'first_name' => $data['shipping_name'],
        //     'last_name' => "",
        //     'email' => $data['shipping_email'],
        //     'phone' => $data['shipping_phone'],
        //     'billing_address' => $data['shipping_address'],
        //     'shipping_address' => $data['shipping_address'],
        // );

        // // Prepare transaction data
        // $transaction = array(
        //     'transaction_details' => $transaction_details,
        //     'customer_details' => $customer_details,
        //     'item_details' => $item_details2,
        // );

        // require_once dirname(__FILE__) . '../../../../../vendor/midtrans/midtrans-php/Midtrans.php';
        // Config::$serverKey = "SB-Mid-server-6yRH0st2uEeYV0ZgW_8MHzXU";
        // Config::$isSanitized = Config::$is3ds = true;
        // // Get SnapToken from Midtrans
        // $snapToken = \Midtrans\Snap::getSnapToken($transaction);

        // // Load the view with the snapToken
        // return view('frontend.payment.pembayaran', compact('snapToken'));

        require_once dirname(__FILE__) . '../../../../../vendor/midtrans/midtrans-php/Midtrans.php';

        //konfigurasi midtrans
        Config::$serverKey = "SB-Mid-server-6yRH0st2uEeYV0ZgW_8MHzXU";
        Config::$isSanitized = Config::$is3ds = true;
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$is3ds = config('services.midtrans.is3ds');


        /*Bagian Proses Order setelah checkout dan bayar lewat Midtrans */

        $item_details = [];
        $shippingCost = (float) $request->hidden_shipping_cost;
        $taxCost = (float) $request->tax;
        foreach (Cart::content() as $cartItem) {
            $item_details[] = [
                'id' => $cartItem->id,
                'price' => (float) $cartItem->price + $shippingCost + $taxCost,
                'quantity' => $cartItem->qty,
                'name' => $cartItem->name,
            ];
                    // Ambil produk dari database
            $product = Products::find($cartItem->id);

            if ($product) {
                // Kurangi stok produk sesuai dengan jumlah yang dibeli
                $product->amount -= $cartItem->qty;

                // Pastikan stok produk tidak menjadi negatif
                if ($product->amount < 0) {
                    $product->amount = 0; // Atur ke 0 jika stok negatif
                }

                // Simpan perubahan jumlah stok produk ke dalam database
                $product->save();
            }
        }

          // Membuat data array midtrans
          $midtrans = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => (float) $cartItem->price + $shippingCost + $taxCost,
            ),
            'customer_details' => array(
                'first_name' => $data['shipping_name'],
                'email' => $data['shipping_email'],
            ),
            'enabled_payments' => array('bank_transfer'),
            'vtweb' => array(),
        );



        $selectedProvince = Province::findOrFail($request->division_id);
        $selectedCity = Regency::findOrFail($request->district_id);
        Pengiriman::create([
            'user_id' => Auth::id(),
            'address' => $request->shipping_address,
            'province' => $selectedProvince->name,
            'city' => $selectedCity->name,
            'postal_code' => $request->post_code,
            'biaya_ongkir' => $shippingCost,
            'courier'=> $request->courier,
            'created_at' => Carbon::now(),
        ]);

        //         $totalAmount = 0;
        // foreach ($item_details as $item) {
        //     $totalAmount += (float) $item['price'];
        // }
        // $totalAmount += $shippingCost +$taxCost;

        $newOrder = new Orders();
        $newOrder->order_id = Orders::generateCustomeId();
        $newOrder->user_id = Auth::id();
        $newOrder->status = 0;
        // $cartTotal = str_replace(',', '', $cartTotal); // Remove commas
        // $cartTotal = (float) $cartTotal; // Convert to float
        $newOrder->total_amount = (float) $cartItem->price + $shippingCost + $taxCost;
        $newOrder->notes = $request->notes;
        $newOrder->tracking_number = $newOrder->generateTrackingNumber();
        $newOrder->save();


        // Create order items
        foreach ($item_details as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $newOrder->order_id;
            $orderItem->product_id = $item['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->save();
        }

        //memilih methode pembayaran dari Midtrans
        // $selectedPaymentMethod = '';
        // foreach($midtrans['enabled_payments'] as $enabledPaymentMethod){
        //     if(in_array($enabledPaymentMethod,$midtrans['enabled_payments'])){
        //         $selectedPaymentMethod=$enabledPaymentMethod;
        //     }
        // }
        $enabledPaymentMethods = $midtrans['enabled_payments'];
        $selectedPaymentMethod = reset($enabledPaymentMethods);


        //bagian payment methode
        $paymentMethod = new PaymentMethod();
        $paymentMethod->order_id = $newOrder->order_id;
        $paymentMethod->name = $selectedPaymentMethod;
        $paymentMethod->save();

        //bagian order payment
        $order = $newOrder;
        $payment = $paymentMethod;


        $orderPayment = new OrderPayment();
        $orderPayment->order_id = $order->order_id;
        $orderPayment->payment_method_id = $payment->id;
        $orderPayment->status_pembayaran = 0;
        $orderPayment->bukti_bayar = '';
        $orderPayment->save();

        /*Akhir dari proses Order */
        $midtrans['item_details'] = $item_details;
        try {
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect ke halaman midtrans
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
