<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class PsychologicalReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'test_session_id',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_by',
    ];

    // Relationships
    public function testSession()
    {
        return $this->belongsTo(TestSession::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessors
    public function getFileSizeFormattedAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    // Delete file when model is deleted
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($report) {
            if ($report->file_path && Storage::exists($report->file_path)) {
                Storage::delete($report->file_path);
            }
        });
    }
}
