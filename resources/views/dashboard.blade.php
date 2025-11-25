<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Demanchys Lounge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold">Demanchys Lounge - Dashboard</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Welcome, {{ Auth::user()->name }}!</span>
                    <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">View Site</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Admin Dashboard</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- Menu Management Card -->
                        <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold mb-3">Menu Management</h3>
                            <p class="text-gray-600 mb-4">Manage your menu items, categories, and add-ons</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800">Manage Menu →</a>
                        </div>

                        <!-- Events Management Card -->
                        <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold mb-3">Events Management</h3>
                            <p class="text-gray-600 mb-4">Create and manage events</p>
                            <a href="{{ route('admin.events.index') }}" class="text-blue-600 hover:text-blue-800">Manage Events →</a>
                        </div>

                        <!-- Bookings Management Card -->
                        <div class="border rounded-lg p-6 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold mb-3">Bookings</h3>
                            <p class="text-gray-600 mb-4">View and manage table bookings</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800">View Bookings →</a>
                        </div>
                    </div>

                    <div class="mt-8 p-4 bg-green-50 rounded-lg">
                        <p class="text-green-800">🎉 You're successfully logged in! Your authentication is working.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>