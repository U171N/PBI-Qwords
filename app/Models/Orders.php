<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $primaryKey='order_id';
    public $incrementing = false;

     //membuat generate ID product
     public static function generateCustomeId(){
        $latestOrder =self::select('order_id')
        ->whereNotNull('order_id')
        ->orderBy('order_id','desc')
        ->first();

        //membuat generate number id
        $lastNumber = $latestOrder? (int)substr($latestOrder->order_id,-5) : 0;
        $newNumber = $lastNumber + 1;

        //membuat format number id
        $formatNumber = str_pad($newNumber,5,'0',STR_PAD_LEFT);

        //generate number id
        $id_order = 'ORD-' . date('Y') . '-' . $formatNumber;

        return $id_order;
    }

    //membuat generate tracking number
    public function generateTrackingNumber(){
        $trackingNumber= 'SHP-'.date('Ymd').'-' . $this->order_id;
        return $trackingNumber;
    }

    //relasi untuk menampilkan data penjualan dan pendapatan dari transaksi
    public function orderItems(){
        return $this->hasMany(OrderItem::class,'order_id','order_id');
    }

    //relasi dengan table user
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    //relasi dengan table orderpayment
    public function payments(){
        return $this->hasMany(OrderPayment::class,'order_id','order_id');
    }


    public function checkPaymentProof($orderId)
    {
        $order = Orders::findOrFail($orderId);
        return $order->payments->isNotEmpty(); // Assuming payments is the relationship for payment proofs

    }


    public function hasPaymentProof(){
        // return $this->payments && $this->payments->bukti_bayar;

        return $this->payments->contains(function ($payment) {
            return !is_null($payment->bukti_bayar);
        }) ? 'invoice' : 'upload';
    }

    //relasi ke method payment
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'order_id', 'order_id');
    }



    //relasi dengan tabel pengiriman
    public function pengirimens(){
        return $this->hasMany(Pengiriman::class, 'user_id', 'user_id');
    }

    //relasi dengan tabel review product
    public function testimoniProduk(){
        return $this->belongsTo(ProductReview::class,'user_id','user_id');
    }
}
