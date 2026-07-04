<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\Evaluation;
use App\Models\Feedback;
use App\Models\Internship;
use App\Models\Student;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Coordinator / Admin ---
        User::create([
            'name' => 'Dr. Amina Rahman',
            'email' => 'coordinator@interntrack.test',
            'password' => Hash::make('password'),
            'role' => 'coordinator',
            'phone' => '+880 1711-000000',
        ]);

        // --- Supervisors ---
        $supervisorDefs = [
            ['name' => 'Farhan Kabir', 'department' => 'Computer Science', 'designation' => 'Senior Software Engineer', 'company_name' => 'NextGen Softwares'],
            ['name' => 'Nusrat Jahan', 'department' => 'Business Administration', 'designation' => 'Marketing Manager', 'company_name' => 'BrightPath Consulting'],
            ['name' => 'Imran Chowdhury', 'department' => 'Electrical Engineering', 'designation' => 'Lead Hardware Engineer', 'company_name' => 'Volta Systems'],
        ];

        $supervisors = collect($supervisorDefs)->map(function ($def, $i) {
            $user = User::create([
                'name' => $def['name'],
                'email' => 'supervisor' . ($i + 1) . '@interntrack.test',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
                'phone' => '+880 1811-00000' . $i,
            ]);

            return Supervisor::create([
                'user_id' => $user->id,
                'designation' => $def['designation'],
                'department' => $def['department'],
                'company_name' => $def['company_name'],
            ]);
        });

        // --- Students ---
        $studentDefs = [
            ['name' => 'Rafiul Islam', 'department' => 'Computer Science', 'program' => 'BSc in CSE', 'supervisor' => 0, 'status' => 'ongoing'],
            ['name' => 'Sadia Afrin', 'department' => 'Computer Science', 'program' => 'BSc in CSE', 'supervisor' => 0, 'status' => 'completed'],
            ['name' => 'Tanvir Ahmed', 'department' => 'Business Administration', 'program' => 'BBA', 'supervisor' => 1, 'status' => 'ongoing'],
            ['name' => 'Meherun Nesa', 'department' => 'Business Administration', 'program' => 'BBA', 'supervisor' => 1, 'status' => 'pending'],
            ['name' => 'Shakil Ahmed', 'department' => 'Electrical Engineering', 'program' => 'BSc in EEE', 'supervisor' => 2, 'status' => 'ongoing'],
            ['name' => 'Farzana Akter', 'department' => 'Electrical Engineering', 'program' => 'BSc in EEE', 'supervisor' => null, 'status' => null],
        ];

        foreach ($studentDefs as $i => $def) {
            $user = User::create([
                'name' => $def['name'],
                'email' => 'student' . ($i + 1) . '@interntrack.test',
                'password' => Hash::make('password'),
                'role' => 'student',
                'phone' => '+880 1911-00000' . $i,
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'student_no' => 'STU-2026-' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'department' => $def['department'],
                'program' => $def['program'],
                'semester' => '7th',
                'supervisor_id' => $def['supervisor'] !== null ? $supervisors[$def['supervisor']]->id : null,
            ]);

            if (! $def['status']) {
                continue;
            }

            $internship = Internship::create([
                'student_id' => $student->id,
                'title' => 'Software Development Intern',
                'company_name' => $def['supervisor'] !== null ? $supervisors[$def['supervisor']]->company_name : 'TBD',
                'company_address' => 'Dhaka, Bangladesh',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->addMonths(1),
                'total_hours_required' => 400,
                'status' => $def['status'],
                'description' => 'Working on real-world projects under industry mentorship as part of the academic internship program.',
            ]);

            // Sample activity logs
            for ($w = 1; $w <= 4; $w++) {
                $log = ActivityLog::create([
                    'internship_id' => $internship->id,
                    'log_date' => now()->subWeeks(4 - $w),
                    'title' => 'Week ' . $w . ' progress',
                    'description' => 'Completed assigned tasks, attended team meetings, and documented progress for week ' . $w . '.',
                    'hours_spent' => 35 + $w,
                    'status' => $w <= 2 ? 'reviewed' : 'pending',
                ]);

                if ($w <= 2 && $def['supervisor'] !== null) {
                    Feedback::create([
                        'activity_log_id' => $log->id,
                        'supervisor_id' => $supervisors[$def['supervisor']]->id,
                        'comment' => 'Good progress this week. Keep documenting your work clearly and ask questions early.',
                        'rating' => 4,
                    ]);
                }
            }

            if ($def['status'] === 'completed' && $def['supervisor'] !== null) {
                Evaluation::create([
                    'internship_id' => $internship->id,
                    'supervisor_id' => $supervisors[$def['supervisor']]->id,
                    'technical_skills' => 5,
                    'communication' => 4,
                    'teamwork' => 5,
                    'punctuality' => 4,
                    'initiative' => 5,
                    'overall_rating' => 4.6,
                    'comments' => 'An excellent intern who consistently delivered high quality work and worked well with the team.',
                    'evaluation_date' => now()->subDays(2),
                ]);
            }
        }
    }
}
