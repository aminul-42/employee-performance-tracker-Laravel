<!-- resources/views/admin/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: black;
            color: #3B82F6; 
        }
        .hero-bg {
            background: blue 
        }
        .btn-primary {
            background-color: black
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
        .form-input {
            background-color: black;
            color: #E2E8F0; /* Light text for contrast */
            border: 1px solid #4B5563;
        }
        .form-input:focus {
            outline: none;
            border-color: #3B82F6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        .error-message {
            color: #EF4444; /* Red for errors */
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen">
    <div class="hero-bg p-8 rounded-lg shadow-lg w-full max-w-md fade-in">
        <h2 class="text-3xl font-bold mb-6 text-center text-white">Admin Login</h2>
        @if ($errors->has('email'))
            <p class="error-message text-sm mb-4 text-center">{{ $errors->first('email') }}</p>
        @endif
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-4 fade-in" style="animation-delay: 0.2s;">
                <label for="email" class="block text-sm font-medium text-white">Email</label>
                <input type="email" name="email" id="email" required
                       class="form-input mt-1 p-2 w-full rounded">
            </div>
            <div class="mb-6 fade-in" style="animation-delay: 0.4s;">
                <label for="password" class="block text-sm font-medium text-white">Password</label>
                <input type="password" name="password" id="password" required
                       class="form-input mt-1 p-2 w-full rounded">
            </div>
            <button type="submit"
                    class="btn-primary text-white font-semibold py-3 px-6 w-full rounded-lg fade-in"
                    style="animation-delay: 0.6s;">
                Login
            </button>
        </form>
    </div>
</body>
</html>