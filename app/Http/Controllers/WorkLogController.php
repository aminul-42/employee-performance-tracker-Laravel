<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;

class WorkLogController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::all();
        $workLogs = WorkLog::with('employee', 'attendance')
            ->when($request->employee_id, fn($query) => $query->where('employee_id', $request->employee_id))
            ->when($request->date_from, fn($query) => $query->whereDate('date', '>=', $request->date_from))
            ->when($request->date_to, fn($query) => $query->whereDate('date', '<=', $request->date_to))
            ->orderBy('date', 'desc')
            ->paginate(15);

        // Fetch attendances for the dropdown, filtered by employee_id if provided
        $attendances = Attendance::when($request->employee_id, fn($query) => $query->where('employee_id', $request->employee_id))
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.dashboard.work-logs.index', compact('workLogs', 'employees', 'attendances'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'attendance_id' => 'nullable|exists:attendances,id',
            'date' => 'required|date',
            'task_description' => 'required|string|max:1000',
            'hours_spent' => 'required|numeric|min:0|max:24',
            'progress' => 'required|in:not_started,in_progress,completed',
        ]);

        WorkLog::create($validated);

        return redirect()->route('admin.work_logs.index')->with('success', 'Work log recorded successfully.');
    }
}