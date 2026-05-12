<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisualPack extends Model
{
    protected $fillable = [
        'user_id',
        'hpp_calculation_id',
        'name',
        'data',
        'images'
    ];

    protected $casts = [
        'data' => 'array',
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hppCalculation()
    {
        return $this->belongsTo(HppCalculation::class);
    }
}
