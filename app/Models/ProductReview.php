<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $guarded=[];

//relasi ke table product
public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'product_id');
}

//relasi ke table user
public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'id'); //user_id adalah field dari table ProductReview yang melakukan relasi table
}

}
