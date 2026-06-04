<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JointCalls extends Model
{
    protected $table = 'joint_calls';
    protected $fillable = ['customer_name', 'vendor', 'vendor_rep', 'date_worked', 'comments','user_id'];

   
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
