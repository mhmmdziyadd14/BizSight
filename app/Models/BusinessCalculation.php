<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_name', 'hpp', 'selling_price', 
        'ads_per_unit', 'operational_fee', 'est_batch_quantity',
        'net_profit', 'net_margin_percent', 'bep_unit',
        'status_label', 'logic_reason', 'action_required',
        'hpp_calculation_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}