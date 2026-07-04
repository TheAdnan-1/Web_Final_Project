<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_log_id',
        'supervisor_id',
        'comment',
        'rating',
    ];

    public function activityLog()
    {
        return $this->belongsTo(ActivityLog::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }
}
