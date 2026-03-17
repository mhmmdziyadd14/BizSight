<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HppCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'hpp_id', 'name', 'category',
        'total_raw_material_cost', 'screen_printing_fee',
        'sewing_fee', 'other_fees', 'total_hpp_per_unit',
        'target_selling_price',
    ];

    public function items()
    {
        return $this->hasMany(HppMaterialItem::class);
    }
}

