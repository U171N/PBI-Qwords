<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;
    // protected $table = 'order_payments';
    protected $primaryKey = 'order_id';

    protected $guarded=[];

    //relasi dengan table order
    public function order(){
        return $this->belongsTo(Orders::class);
    }

    //relasi dengan table payment methode
    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class, 'order_id', 'order_id');
    }

    public function bukti_bayar()
{
    return $this->bukti_bayar !== null;
}
}
