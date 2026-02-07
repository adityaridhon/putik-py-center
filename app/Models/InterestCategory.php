<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestCategory extends Model
{
    protected $fillable = [
        'code',
        'name',
        'instruction',
        'has_jobs',
        'order',
    ];

    protected $casts = [
        'has_jobs' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(InterestJob::class, 'category_id')->orderBy('order');
    }
}
