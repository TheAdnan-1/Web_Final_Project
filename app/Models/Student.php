<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_no',
        'department',
        'program',
        'semester',
        'supervisor_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function currentInternship()
    {
        return $this->internships()->latest('start_date')->first();
    }
}
