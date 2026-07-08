<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'job_id',
        'customer_id',
        'professional_id',
        'amount',
        'platform_fee',
        'professional_payout_amount',
        'payment_method',
        'status',
        'transaction_reference',
        'paid_at',
    ];

    protected $casts = [
        'amount'                    => 'decimal:2',
        'platform_fee'              => 'decimal:2',
        'professional_payout_amount'=> 'decimal:2',
        'paid_at'                   => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(CustomerJob::class, 'job_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
