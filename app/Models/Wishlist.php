<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $primaryKey='id';
    public $incrementing = false;
     //membuat generate ID product
     public static function generateCustomeId(){
        $latestWishlist =self::select('id')
        ->whereNotNull('id')
        ->orderBy('id','desc')
        ->first();

        //membuat generate number id
        $lastNumber = $latestWishlist? (int)substr($latestWishlist->id,-5) : 0;
        $newNumber = $lastNumber + 1;

        //membuat format number id
        $formatNumber = str_pad($newNumber,5,'0',STR_PAD_LEFT);

        //generate number id
        $id_wishlist = 'WST-' . date('Y') . '-' . $formatNumber;

        return $id_wishlist;
    }


    //endpoint relasi dengan table product
    public function product(){
        return $this->belongsTo(Products::class,'product_id','product_id');
    }
}
