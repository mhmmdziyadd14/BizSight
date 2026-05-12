<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNotification extends Model
{
    protected $fillable = [
        'product_name',
        'name',
        'phone',
        'social_media',
    ];
}
