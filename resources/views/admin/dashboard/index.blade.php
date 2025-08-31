<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .progress-bar {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 5px;
            overflow: hidden;
        }
        .progress {
            height: 20px;
            background-color: #4caf50;
            transition: width 0.3s ease-in-out;
        }
        .best-employee {
            background-color: #10B981;
            color: white;
            padding: 1rem;
            border-radius: 5px;
        }
        .lazy-employee {
            background-color: #EF4444;
            color: white;
            padding: 1rem;
            border-radius: 5px;
        }
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex">
        <!-- Sidebar -->
        @include('admin.dashboard.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-6 bg-gray-900 text-gray-100">
            <header class="mb-6">
                <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            </header>

            <!-- Success / Error Messages -->
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

            <!-- Work Progress -->
            <div class="mb-6 bg-gray-800 p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2">Overall Work Progress</h2>
                <div class="progress-bar">
                    <div id="progress" class="progress" style="width: {{ $workProgress }}%;"></div>
                </div>
                <p class="text-sm text-gray-400 mt-1">{{ $workProgress }}% of tasks completed</p>
            </div>

            <!-- Best and Lazy Employees -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="best-employee">
                    <h2 class="text-lg font-semibold mb-2">Best Employee</h2>
                    @if($bestEmployee)
                        <p>Name: {{ $bestEmployee->name }}</p>
                        <p>Total Worked Hours: {{ $bestEmployee->attendances->sum('worked_hours') }}</p>
                        <p>Completed Tasks: {{ $bestEmployee->workLogs->where('progress', 'completed')->count() }}</p>
                    @else
                        <p>No data available</p>
                    @endif
                </div>
                <div class="lazy-employee">
                    <h2 class="text-lg font-semibold mb-2">Least Active Employee</h2>
                    @if($lazyEmployee)
                        <p>Name: {{ $lazyEmployee->name }}</p>
                        <p>Absences: {{ $lazyEmployee->attendances->where('status', 'absent')->count() }}</p>
                        <p>Total Worked Hours: {{ $lazyEmployee->attendances->sum('worked_hours') }}</p>
                    @else
                        <p>No data available</p>
                    @endif
                </div>
            </div>

            <!-- Employee Details -->
            <div class="mb-6 bg-gray-800 p-4 rounded shadow">
                <h2 class="text-lg font-semibold mb-2">Employee Details</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="p-2">Name</th>
                                <th class="p-2">Email</th>
                                <th class="p-2">Role</th>
                                <th class="p-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr class="border-b border-gray-700 hover:bg-gray-600">
                                    <td class="p-2">{{ $employee->name }}</td>
                                    <td class="p-2">{{ $employee->email }}</td>
                                    <td class="p-2">{{ $employee->role }}</td>
                                    <td class="p-2 {{ $employee->status == 'active' ? 'text-green-400' : 'text-red-400' }}">{{ ucfirst($employee->status) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-4 text-center text-gray-400">No employees found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $employees->links() }}
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-800 p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-2">Attendance Overview</h2>
                    <canvas id="attendanceChart"></canvas>
                </div>
                <div class="bg-gray-800 p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-2">Work Log Distribution</h2>
                    <canvas id="taskChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Progress Bar Animation
        document.addEventListener('DOMContentLoaded', () => {
            const progress = document.getElementById('progress');
            progress.style.width = '0%';
            setTimeout(() => {
                progress.style.width = '{{ $workProgress }}%';
            }, 100);
        });

        // Attendance Chart (Bar)
        const attendanceChart = new Chart(document.getElementById('attendanceChart'), {
            type: 'bar',
            data: {
                labels: [@foreach($employees as $employee)'{{ $employee->name }}', @endforeach],
                datasets: [{
                    label: 'Total Worked Hours',
                    data: [@foreach($employees as $employee){{ $employee->attendances->sum('worked_hours') }}, @endforeach],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Hours'
                        }
                    }
                }
            }
        });

        // Work Log Distribution Chart (Pie)
        const taskChart = new Chart(document.getElementById('taskChart'), {
            type: 'pie',
            data: {
                labels: ['Completed', 'In Progress', 'Not Started'],
                datasets: [{
                    label: 'Work Logs',
                    data: [
                        {{ $workLogs->where('progress', 'completed')->count() }},
                        {{ $workLogs->where('progress', 'in_progress')->count() }},
                        {{ $workLogs->where('progress', 'not_started')->count() }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>
</body>
</html>