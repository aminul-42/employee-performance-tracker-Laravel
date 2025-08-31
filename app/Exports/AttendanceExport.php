<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        return Attendance::with('employee')
            ->when($this->filters['employee_id'] ?? null, fn($query) => $query->where('employee_id', $this->filters['employee_id']))
            ->when($this->filters['date_from'] ?? null, fn($query) => $query->whereDate('date', '>=', $this->filters['date_from']))
            ->when($this->filters['date_to'] ?? null, fn($query) => $query->whereDate('date', '<=', $this->filters['date_to']))
            ->orderBy('date', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Date',
            'Check In',
            'Check Out',
            'Status',
            'Worked Hours',
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->employee->name,
            $attendance->date->format('Y-m-d'),
            $attendance->check_in?->format('H:i'),
            $attendance->check_out?->format('H:i'),
            ucfirst($attendance->status),
            $attendance->worked_hours,
        ];
    }
}