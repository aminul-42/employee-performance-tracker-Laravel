<!-- resources/views/admin/employees/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
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
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.3s ease;
        }
        .btn-view {
            background-color: #10B981;
        }
        .btn-view:hover {
            background-color: #059669;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .btn-edit {
            background-color: #F59E0B;
        }
        .btn-edit:hover {
            background-color: #D97706;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }
        .btn-delete {
            background-color: #EF4444;
        }
        .btn-delete:hover {
            background-color: #DC2626;
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
        .modal {
            display: none;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal.show {
            display: flex;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="flex">
        @include('admin.dashboard.sidebar')

        <div class="flex-1 p-6 bg-gray-900 text-gray-100">
            <header class="mb-6">
                <h1 class="text-2xl font-bold">Employees</h1>
            </header>

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-800 rounded fade-in">
                    {{ session('success') }}
                </div>
            @endif

            <a href="{{ route('admin.employees.create') }}" class="btn-primary text-white py-2 px-4 rounded mb-4 inline-block fade-in">Add Employee</a>

            <div class="bg-gray-800 p-4 rounded shadow">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-700">
                            <th class="p-2">Profile</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Email</th>
                            <th class="p-2">Role</th>
                            <th class="p-2">Phone</th>
                            <th class="p-2">Salary</th>
                            <th class="p-2">Join Date</th>
                            <th class="p-2">Status</th>
                            <th class="p-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr class="border-b border-gray-700">
                                <td class="p-2">
                                    @if ($employee->profile_picture)
                                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="{{ $employee->name }}" class="w-10 h-10 rounded-full">
                                    @else
                                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                                            <span>{{ strtoupper($employee->name[0]) }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="p-2">{{ $employee->name }}</td>
                                <td class="p-2">{{ $employee->email }}</td>
                                <td class="p-2">{{ $employee->role }}</td>
                                <td class="p-2">{{ $employee->phone_number ?? 'N/A' }}</td>
                                <td class="p-2">{{ $employee->salary ? number_format($employee->salary, 2) : 'N/A' }}</td>
                                <td class="p-2">{{ $employee->join_date ? $employee->join_date->format('Y-m-d') : 'N/A' }}</td>
                                <td class="p-2 {{ $employee->status === 'Active' ? 'text-green-400' : 'text-red-400' }}">{{ $employee->status }}</td>
                                <td class="p-2 flex space-x-2">
                                    <a href="{{ route('admin.employees.show', $employee) }}" class="btn-action btn-view text-white text-sm">View</a>
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn-action btn-edit text-white text-sm">Edit</a>
                                    <button onclick="showDeleteModal('{{ route('admin.employees.destroy', $employee) }}')" class="btn-action btn-delete text-white text-sm">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal fixed inset-0 items-center justify-center">
        <div class="bg-gray-800 p-6 rounded shadow-lg max-w-sm w-full">
            <h3 class="text-lg font-bold text-white mb-4">Confirm Deletion</h3>
            <p class="text-gray-300 mb-4">Are you sure you want to delete this employee?</p>
            <div class="flex justify-end space-x-2">
                <button onclick="closeDeleteModal()" class="btn-primary text-white py-2 px-4 rounded">Cancel</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-action btn-delete text-white py-2 px-4 rounded">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(url) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            form.action = url;
            modal.classList.add('show');
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
        }
    </script>
</body>
</html>