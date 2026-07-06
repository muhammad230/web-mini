<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $table = 'site_content';

    protected $fillable = ['section', 'content', 'last_updated_by'];

    protected function casts(): array
    {
        return [
            'content' => 'array',
        ];
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }
}
