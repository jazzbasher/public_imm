<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewOpportunities extends Model
{
    protected $table = 'new_opportunities';
    protected $fillable = ['customer', 'interest', 'quote', 'projected_value', 'close_date', 'confidence', 'rep', 'comments', 'user_id'];

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
