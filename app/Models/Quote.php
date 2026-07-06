<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'job_id', 'pro_id', 'amount', 'message', 'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    public function job()
    {
        return $this->belongsTo(CustomerJob::class, 'job_id');
    }

    public function pro()
    {
        return $this->belongsTo(User::class, 'pro_id');
    }
}
