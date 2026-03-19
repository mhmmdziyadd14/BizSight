<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'user_id',
        'purchase_date',
        'type',
        'name',
        'color',
        'price',
        'purchase_volume',
        'unit',
        'stock_initial',
        'stock_in',
        'stock_out',
    ];
}
