<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendingPipeline extends Model
{
    protected $table = 'vending_pipeline';
    protected $fillable = ['customer', 'address', 'estimated_spend', 'presentation', 'site_survey', 'comments','user_id'];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
