<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'title',
        'company_name',
        'company_address',
        'start_date',
        'end_date',
        'total_hours_required',
        'status',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function totalHoursLogged(): float
    {
        return (float) $this->activityLogs()->sum('hours_spent');
    }

    public function progressPercent(): int
    {
        if (! $this->total_hours_required) {
            return 0;
        }

        return (int) min(100, round(($this->totalHoursLogged() / $this->total_hours_required) * 100));
    }

    public function statusBadgeColor(): string
    {
        return match ($this->status) {
            'pending' => 'amber',
            'ongoing' => 'blue',
            'completed' => 'emerald',
            'terminated' => 'red',
            default => 'slate',
        };
    }
}
