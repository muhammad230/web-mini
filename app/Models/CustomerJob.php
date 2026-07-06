<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerJob extends Model
{
    protected $fillable = [
        'customer_id', 'assigned_pro_id', 'trade_category', 'description',
        'location', 'budget_type', 'budget_min', 'budget_max', 'schedule',
        'status', 'amount_paid', 'completed_at'
    ];

    protected $casts = [
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'completed_at' => 'datetime'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function assignedPro()
    {
        return $this->belongsTo(User::class, 'assigned_pro_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'job_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class, 'job_id');
    }
}
