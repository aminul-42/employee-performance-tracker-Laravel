<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::all();
        $attendances = Attendance::with('employee')
            ->when($request->employee_id, fn($query) => $query->where('employee_id', $request->employee_id))
            ->when($request->date_from, fn($query) => $query->whereDate('date', '>=', $request->date_from))
            ->when($request->date_to, fn($query) => $query->whereDate('date', '<=', $request->date_to))
            ->orderBy('date', 'desc')
            ->paginate(15);

        return view('admin.dashboard.attendance.index', compact('attendances', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,late,half_day',
        ]);

        $worked_hours = null;
        if ($request->check_in && $request->check_out) {
            $checkIn = \Carbon\Carbon::parse($request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->check_out);
            $worked_hours = number_format($checkIn->diffInHours($checkOut, false), 2);
        }

        Attendance::create([
            'employee_id' => $request->employee_id,
            'date' => $request->date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
            'worked_hours' => $worked_hours,
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function export(Request $request)
    {
        $type = $request->type ?? 'excel';
        $filename = 'attendance_report_' . now()->format('Ymd_His');

        if ($type === 'pdf') {
            $attendances = Attendance::with('employee')
                ->when($request->employee_id, fn($query) => $query->where('employee_id', $request->employee_id))
                ->when($request->date_from, fn($query) => $query->whereDate('date', '>=', $request->date_from))
                ->when($request->date_to, fn($query) => $query->whereDate('date', '<=', $request->date_to))
                ->orderBy('date', 'desc')
                ->get();

            $pdf = Pdf::loadView('admin.dashboard.attendance.pdf', compact('attendances'));
            return $pdf->download($filename . '.pdf');
        }

        return Excel::download(new AttendanceExport($request->all()), $filename . '.xlsx');
    }
}