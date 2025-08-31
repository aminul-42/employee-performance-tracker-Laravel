<!-- resources/views/admin/work_logs/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Logs Management</title>
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
            <h1 class="text-2xl font-bold">Work Logs Management</h1>
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

        {{-- Add Work Log Form --}}
        <form method="POST" action="{{ route('admin.work_logs.store') }}" class="mb-6 bg-gray-800 p-4 rounded shadow">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                    <label class="block text-sm font-medium">Attendance</label>
                    <select name="attendance_id" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white">
                        <option value="">Select Attendance (Optional)</option>
                        @foreach($attendances as $attendance)
                            <option value="{{ $attendance->id }}">{{ $attendance->date->format('Y-m-d') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-3">
                    <label class="block text-sm font-medium">Task Description</label>
                    <textarea name="task_description" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white" rows="3" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Hours Spent</label>
                    <input type="number" name="hours_spent" step="0.1" min="0" max="24" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Progress</label>
                    <select name="progress" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white" required>
                        <option value="not_started">Not Started</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="mt-4 btn-primary text-white px-4 py-2 rounded">Add Work Log</button>
        </form>

        {{-- Work Logs Table --}}
        <div class="bg-gray-800 p-4 rounded shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="py-2 px-4 text-left">Employee</th>
                        <th class="py-2 px-4 text-left">Date</th>
                        <th class="py-2 px-4 text-left">Task Description</th>
                        <th class="py-2 px-4 text-left">Hours Spent</th>
                        <th class="py-2 px-4 text-left">Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($workLogs as $log)
                        <tr class="border-b border-gray-700 hover:bg-gray-600 transition">
                            <td class="py-2 px-4">{{ $log->employee->name }}</td>
                            <td class="py-2 px-4">{{ $log->date->format('Y-m-d') }}</td>
                            <td class="py-2 px-4">{{ Str::limit($log->task_description, 50) }}</td>
                            <td class="py-2 px-4">{{ $log->hours_spent }}</td>
                            <td class="py-2 px-4 capitalize">{{ str_replace('_', ' ', $log->progress) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-4 text-center text-gray-400">No work logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                {{ $workLogs->links() }}
            </div>
        </div>
    </div>
</div>
</body>
</html>
