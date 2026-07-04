<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'log_date',
        'title',
        'description',
        'hours_spent',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
        ];
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }
}
