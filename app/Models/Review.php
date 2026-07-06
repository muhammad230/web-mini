<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['job_id', 'customer_id', 'pro_id', 'rating', 'comment'];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function job()
    {
        return $this->belongsTo(CustomerJob::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function pro()
    {
        return $this->belongsTo(User::class, 'pro_id');
    }
}
