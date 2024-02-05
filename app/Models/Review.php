<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_product_id',
        'review_user_id',
        'review_description',
        'review_rate',
        'review_title'
    ];
}
