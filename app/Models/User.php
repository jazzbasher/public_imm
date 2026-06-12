<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_sales',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin; 
    }

    public function newcustomerleads()
    {
        return $this->hasMany(NewCustomerLeads::class, 'user_id', 'id');
    }

    public function newopps()
    {
        return $this->hasMany(NewOpportunities::class, 'user_id', 'id');
    }

    public function jointcalls()
    {
        return $this->hasMany(JointCalls::class, 'user_id', 'id');
    }

    public function conversions()
    {
        return $this->hasMany(Conversions::class, 'user_id', 'id');
    }

    public function pipelines()
    {
        return $this->hasMany(VendingPipeline::class, 'user_id', 'id');
    }


}
