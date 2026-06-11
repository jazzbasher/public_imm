<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewCustomerLeads extends Model
{
    protected $table = 'new_customer_leads';
    protected $fillable = ['new_lead', 'address', 'date_planned', 'contact_made', 'contactname', 'email', 'comments', 'user_id'];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
