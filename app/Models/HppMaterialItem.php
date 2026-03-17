<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HppMaterialItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'hpp_calculation_id', 'material_id', 'usage_amount', 'subtotal_cost',
    ];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}

