<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'category_id';
    public $incrementing = false;

    public static function generateCustomId()
    {
        // Get the latest project with the highest numeric ID
        $latestCategory = self::select('category_id')
            ->whereNotNull('category_id')
            ->orderBy('category_id', 'desc')
            ->first();

        // Extract the numeric part of the category_id and increment it by 1
        $lastNumber = $latestCategory ? (int)substr($latestCategory->category_id, -5) : 0;
        $newNumber = $lastNumber + 1;

        // Format the numeric part to have leading zeros
        $formattedNumber = str_pad($newNumber, 5, '0', STR_PAD_LEFT);

        // Generate the final custom ID
        $id_category = 'CT-' . date('Y') . '-' . $formattedNumber;

        return $id_category;
    }
    // public function products() {
    //     return $this->belongsToMany(Product::class, 'product_categories');
    // }


}
