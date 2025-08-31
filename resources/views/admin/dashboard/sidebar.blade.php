<aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
    <div class="flex items-center mb-6">
        <div class="w-12 h-12 bg-gray-600 rounded-full flex items-center justify-center">
            <span class="text-xl">{{ auth('admin')->user()->name[0] }}</span>
        </div>
        <div class="ml-3">
            <p class="font-semibold">{{ auth('admin')->user()->name }}</p>
            <p class="text-sm text-gray-400">{{ auth('admin')->user()->email }}</p>
        </div>
    </div>
    <nav>
        <ul>
            <li class="mb-2">
                <a href="{{ route('admin.dashboard') }}" class="block p-2 rounded hover:bg-gray-700">Dashboard</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.employees.index') }}" class="block p-2 rounded hover:bg-gray-700">Employees</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.attendance.index') }}" class="block p-2 rounded hover:bg-gray-700">Attendance</a>
            </li>
            <li class="mb-2">
                <a href="{{ route('admin.work_logs.index') }}" class="block p-2 rounded hover:bg-gray-700">Work Logs</a>
            </li>
            
            
        </ul>
    </nav>
    <form action="{{ route('admin.logout') }}" method="POST" class="mt-6">
        @csrf
        <button type="submit" class="w-full p-2 bg-red-600 rounded hover:bg-red-700">Logout</button>
    </form>
</aside>