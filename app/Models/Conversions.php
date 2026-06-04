<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversions extends Model
{
    protected $table = 'conversions';
    protected $fillable = ['new_supplier', 'supplier_converted_from', 'annual_opp_volume', 'supplier_contact_name', 'end_user', 'product_converted_to', 'comments', 'user_id'];

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
