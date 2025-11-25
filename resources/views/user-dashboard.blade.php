<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Demanchys Lounge</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold">My Account</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800">Back to Site</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-4xl mx-auto py-8 px-4">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}! 👋</h2>
                <p class="text-gray-600 mb-6">This is your personal dashboard</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-3">Profile Information</h3>
                        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Member since:</strong> {{ Auth::user()->created_at->format('M Y') }}</p>
                    </div>

                    <div class="border rounded-lg p-4">
                        <h3 class="font-semibold text-lg mb-3">Quick Actions</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('book.table') }}" class="text-blue-600 hover:text-blue-800">Book a Table</a></li>
                            <li><a href="#" class="text-blue-600 hover:text-blue-800">View My Bookings</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800">Update Profile</a></li>
                        </ul>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <p class="text-blue-800">✨ This is your user dashboard. We'll add more features like booking history and order tracking soon!</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>