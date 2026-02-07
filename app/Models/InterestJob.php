<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterestJob extends Model
{
    protected $fillable = [
        'category_id',
        'job_name',
        'order',
    ];

    public function category()
    {
        return $this->belongsTo(InterestCategory::class, 'category_id');
    }
}
