<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'activity_log_id',
        'title',
        'file_path',
        'file_type',
        'file_size',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function activityLog()
    {
        return $this->belongsTo(ActivityLog::class);
    }

    public function url(): string
    {
        return asset('storage/' . $this->file_path);
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->file_size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }
}
