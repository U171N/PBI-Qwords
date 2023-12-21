<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $primaryKey='product_id';
    public $incrementing = false;

    //membuat generate ID product
    public static function generateCustomeId(){
        $latestProduct =self::select('product_id')
        ->whereNotNull('product_id')
        ->orderBy('product_id','desc')
        ->first();

        //membuat generate number id
        $lastNumber = $latestProduct? (int)substr($latestProduct->product_id,-5) : 0;
        $newNumber = $lastNumber + 1;

        //membuat format number id
        $formatNumber = str_pad($newNumber,5,'0',STR_PAD_LEFT);

        //generate number id
        $id_product = 'PRD-' . date('Y') . '-' . $formatNumber;

        return $id_product;
    }
    public function category(){
        return $this->belongsTo(Categories::class,'category_id','category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'product_id');
    }

    public function hasReviewFromUser($user)
{
    return $this->reviews()->where('user_id', $user->id)->exists();
}
}
