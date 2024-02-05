<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'prod_name',
        'prod_description',
        'prod_name_en',
        'prod_description_en',
        'prod_price',
        'prod_stock_quantity',
        'prod_is_active',
        'prod_rate',
        'prod_opinion',
        'prod_image'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
