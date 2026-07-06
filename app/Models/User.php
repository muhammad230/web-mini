<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password',
        'role', 'trade', 'location', 'verification_status',
        'available', 'bio', 'years_experience', 'starting_price',
        'service_area', 'trades', 'profile_photo', 'total_earnings',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function isAdmin(): bool        { return $this->role === 'admin'; }
    public function isCustomer(): bool     { return $this->role === 'customer'; }
    public function isProfessional(): bool { return $this->role === 'professional'; }

    // Customer relationships
    public function customerJobs()
    {
        return $this->hasMany(CustomerJob::class, 'customer_id');
    }

    public function savedProfessionals()
    {
        return $this->belongsToMany(User::class, 'saved_professionals', 'customer_id', 'pro_id')->withTimestamps();
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function reviewsGiven()
    {
        return $this->hasMany(Review::class, 'customer_id');
    }

    // Professional relationships
    public function assignedJobs()
    {
        return $this->hasMany(CustomerJob::class, 'assigned_pro_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'pro_id');
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'pro_id');
    }

    public function savedByCustomers()
    {
        return $this->belongsToMany(User::class, 'saved_professionals', 'pro_id', 'customer_id')->withTimestamps();
    }
}
