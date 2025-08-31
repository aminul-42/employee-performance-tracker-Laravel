<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Tracker System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: blue;
            color: blue;
        }
        .hero-bg {
            background: black;
        }
        .btn-primary {
            background-color: blue;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: red;
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
<body class="antialiased">
    <!-- Hero Section -->
    <div class="min-h-screen hero-bg flex flex-col justify-center items-center text-center px-4">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 fade-in">Welcome To Employee Tracker System</h1>
        <p class="text-lg md:text-xl text-gray-300 mb-8 max-w-2xl fade-in" style="animation-delay: 0.2s;">
            Streamline your workforce management with our powerful and intuitive platform.
        </p>
        <a href="{{ route('admin.login') }}" class="btn-primary text-white font-semibold py-3 px-6 rounded-lg fade-in" style="animation-delay: 0.4s;">
            Admin Login
        </a>
    </div>

    <!-- Footer -->
    <footer class="bg-black py-4 text-center text-gray-400">
        <p>&copy; {{ date('Y') }}  All rights reserved by Md Aminul Islam Nur</p>
    </footer>
</body>
</html>