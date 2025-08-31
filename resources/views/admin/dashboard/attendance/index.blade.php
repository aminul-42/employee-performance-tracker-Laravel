<!-- resources/views/admin/attendance/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #1A202C; color: #E2E8F0; }
        .btn-primary { background-color: #3B82F6; transition: all 0.3s ease; }
        .btn-primary:hover { background-color: #2563EB; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.3); }
        .btn-success { background-color: #10B981; }
        .btn-success:hover { background-color: #059669; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.3); }
        .btn-danger { background-color: #EF4444; }
        .btn-danger:hover { background-color: #DC2626; transform: translateY(-2px); box-shadow: 0 4px 6px rgba(0,0,0,0.3); }
        .fade-in { animation: fadeIn 0.8s ease-in-out; }
        @keyframes fadeIn { 0% {opacity:0; transform:translateY(20px);} 100% {opacity:1; transform:translateY(0);} }
    </style>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex">
    @include('admin.dashboard.sidebar')

    <div class="flex-1 p-6 bg-gray-900 text-gray-100">
        <header class="mb-6">
            <h1 class="text-2xl font-bold">Attendance Management</h1>
        </header>

        {{-- Success / Error Messages --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-800 rounded fade-in">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-800 rounded fade-in">
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <form class="mb-6" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium">Employee</label>
                    <select name="employee_id" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-800 text-white">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">From Date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-800 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium">To Date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="mt-1 block w-full rounded-md border-gray-600 bg-gray-800 text-white">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="btn-primary text-white px-4 py-2 rounded">Filter</button>
                </div>
            </div>
        </form>

        {{-- Export Buttons --}}
        <div class="mb-6">
            <a href="{{ route('admin.attendance.export', array_merge(request()->query(), ['type' => 'excel'])) }}"
               class="btn-success text-white px-4 py-2 rounded">Export Excel</a>
            <a href="{{ route('admin.attendance.export', array_merge(request()->query(), ['type' => 'pdf'])) }}"
               class="btn-danger text-white px-4 py-2 rounded ml-2">Export PDF</a>
        </div>

        {{-- Add Attendance Form --}}
        <form method="POST" action="{{ route('admin.attendance.store') }}" class="mb-6 bg-gray-800 p-4 rounded shadow">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium">Employee</label>
                    <select name="employee_id" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white" required>
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Date</label>
                    <input type="date" name="date" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Check In</label>
                    <input type="time" name="check_in" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium">Check Out</label>
                    <input type="time" name="check_out" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white" required>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                        <option value="half_day">Half Day</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-4 btn-primary text-white px-4 py-2 rounded">Add Attendance</button>
        </form>

        {{-- Attendance Table --}}
        <div class="bg-gray-800 p-4 rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                <tr class="bg-gray-700">
                    <th class="py-2 px-4 text-left">Employee</th>
                    <th class="py-2 px-4 text-left">Date</th>
                    <th class="py-2 px-4 text-left">Check In</th>
                    <th class="py-2 px-4 text-left">Check Out</th>
                    <th class="py-2 px-4 text-left">Status</th>
                    <th class="py-2 px-4 text-left">Worked Hours</th>
                </tr>
                </thead>
                <tbody>
                @foreach($attendances as $attendance)
                    <tr class="border-b border-gray-700 hover:bg-gray-600 transition">
                        <td class="py-2 px-4">{{ $attendance->employee->name }}</td>
                        <td class="py-2 px-4">{{ $attendance->date->format('Y-m-d') }}</td>
                        <td class="py-2 px-4">{{ $attendance->check_in?->format('H:i') ?? '-' }}</td>
                        <td class="py-2 px-4">{{ $attendance->check_out?->format('H:i') ?? '-' }}</td>
                        <td class="py-2 px-4 capitalize">{{ $attendance->status }}</td>
                        <td class="py-2 px-4">{{ $attendance->worked_hours ?? '-' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
