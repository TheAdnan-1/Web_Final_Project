<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Coordinator\DashboardController as CoordinatorDashboard;
use App\Http\Controllers\Student\DashboardController as StudentDashboard;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->role) {
            'student' => app(StudentDashboard::class)->index($request),
            'supervisor' => app(SupervisorDashboard::class)->index($request),
            'coordinator' => app(CoordinatorDashboard::class)->index($request),
            default => abort(403),
        };
    }
}
