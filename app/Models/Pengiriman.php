<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $guarded=[];

    // public function provinceData()
    // {
    //     return $this->belongsTo(Province::class);
    // }

    // public function cityData()
    // {
    //     return $this->belongsTo(Regency::class);
    // }

}
