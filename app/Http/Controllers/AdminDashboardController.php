<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\WorkLog;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
 // Fetch all employees with pagination
        $employees = Employee::with(['attendances', 'workLogs'])->paginate(10);

        // Fetch all work logs for progress calculation
        $workLogs = WorkLog::all();
        $totalWorkLogs = $workLogs->count();
        $completedWorkLogs = $workLogs->where('progress', 'completed')->count();
        $workProgress = $totalWorkLogs > 0 ? round(($completedWorkLogs / $totalWorkLogs) * 100, 2) : 0;

        // Best employee: Highest total worked hours or most completed tasks
        $bestEmployee = Employee::with(['attendances', 'workLogs'])
            ->get()
            ->sortByDesc(function ($employee) {
                return $employee->attendances->sum('worked_hours') + $employee->workLogs->where('progress', 'completed')->count();
            })
            ->first();

        // Lazy employee: Most absences or least worked hours
        $lazyEmployee = Employee::with('attendances')
            ->get()
            ->sortByDesc(function ($employee) {
                return $employee->attendances->where('status', 'absent')->count();
            })
            ->first();

        return view('admin.dashboard.index', compact('employees', 'workLogs', 'workProgress', 'bestEmployee', 'lazyEmployee'));
    }
}