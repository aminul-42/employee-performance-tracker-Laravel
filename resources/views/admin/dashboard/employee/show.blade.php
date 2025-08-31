<!-- resources/views/admin/employees/show.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #1A202C;
            color: #E2E8F0;
        }
        .btn-primary {
            background-color: #3B82F6;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #2563EB;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .btn-download {
            background-color: #10B981;
            transition: all 0.3s ease;
        }
        .btn-download:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased flex min-h-screen bg-gray-900">
    <div class="flex w-full">
        @include('admin.dashboard.sidebar')

        <div class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-4 text-white">Employee Details</h2>
            <div class="bg-gray-800 p-6 rounded shadow text-gray-300 max-w-md mx-auto">
                @if ($employee->profile_picture)
                    <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->name }}" class="w-24 h-24 rounded-full mb-4 mx-auto">
                @else
                    <div class="w-24 h-24 bg-gray-600 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <span class="text-2xl">{{ strtoupper($employee->name[0]) }}</span>
                    </div>
                @endif
                <p><strong>Name:</strong> {{ $employee->name }}</p>
                <p><strong>Email:</strong> {{ $employee->email }}</p>
                <p><strong>Role:</strong> {{ $employee->role }}</p>
                <p><strong>Status:</strong> {{ $employee->status }}</p>
                <p><strong>Phone Number:</strong> {{ $employee->phone_number ?? 'N/A' }}</p>
                <p><strong>Salary:</strong> {{ $employee->salary ? number_format($employee->salary, 2) : 'N/A' }}</p>
                <p><strong>Join Date:</strong> {{ $employee->join_date ? $employee->join_date->format('Y-m-d') : 'N/A' }}</p>
                <p><strong>Created At:</strong> {{ $employee->created_at }}</p>
                <div class="flex space-x-2 mt-4">
                    <a href="{{ route('admin.employees.index') }}" class="btn-primary text-white py-2 px-4 rounded">Back to List</a>
            
                </div>
            </div>
        </div>
    </div>
</body>
</html>