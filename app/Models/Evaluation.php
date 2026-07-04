<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'supervisor_id',
        'technical_skills',
        'communication',
        'teamwork',
        'punctuality',
        'initiative',
        'overall_rating',
        'comments',
        'evaluation_date',
    ];

    protected function casts(): array
    {
        return [
            'evaluation_date' => 'date',
        ];
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public const CRITERIA = [
        'technical_skills' => 'Technical Skills',
        'communication' => 'Communication',
        'teamwork' => 'Teamwork',
        'punctuality' => 'Punctuality',
        'initiative' => 'Initiative',
    ];
}
