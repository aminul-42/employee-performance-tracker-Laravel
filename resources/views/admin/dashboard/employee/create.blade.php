<!-- resources/views/admin/employees/create.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
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
        .fade-in {
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .form-input {
            background-color: #2D3748;
            color: #E2E8F0;
            border: 1px solid #4B5563;
        }
        .form-input:focus {
            border-color: #3B82F6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        .error-message {
            color: #EF4444;
        }
    </style>
</head>
<body class="antialiased flex min-h-screen bg-gray-900">
    <div class="flex w-full">
        @include('admin.dashboard.sidebar')

        <div class="flex-1 p-6">
            <h2 class="text-2xl font-bold mb-4 text-white">Create Employee</h2>
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-800 rounded fade-in max-w-md mx-auto">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="error-message text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.employees.store') }}" class="bg-gray-800 p-6 rounded shadow max-w-md mx-auto" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                    <input type="text" name="name" id="name" required class="form-input mt-1 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                    <input type="email" name="email" id="email" required class="form-input mt-1 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-sm font-medium text-gray-300">Role</label>
                    <input type="text" name="role" id="role" required class="form-input mt-1 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-300">Status</label>
                    <select name="status" id="status" required class="form-input mt-1 p-2 w-full rounded">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="profile_picture" class="block text-sm font-medium text-gray-300">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="form-input mt-1 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block text-sm font-medium text-gray-300">Phone Number</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-input mt-1 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="salary" class="block text-sm font-medium text-gray-300">Salary</label>
                    <input type="number" name="salary" id="salary" step="0.01" class="form-input mt-1 p-2 w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="join_date" class="block text-sm font-medium text-gray-300">Join Date</label>
                    <input type="date" name="join_date" id="join_date" class="form-input mt-1 p-2 w-full rounded">
                </div>
                <button type="submit" class="btn-primary text-white py-2 px-4 rounded w-full">Create</button>
            </form>
        </div>
    </div>
</body>
</html>