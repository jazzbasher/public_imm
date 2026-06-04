<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentPromo extends Model
{
    protected $table = 'current_promo';
    protected $fillable = ['promo_date', 'customer', 'contact_name', 'sample', 'comments','user_id'];

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
