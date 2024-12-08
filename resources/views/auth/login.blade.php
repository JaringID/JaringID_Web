<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jaring.ID</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-poppins bg-gray-100 flex justify-center items-center h-screen">
    <div class="w-full max-w-md p-6 bg-white shadow-lg rounded-md">
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Login</h1>
        <p class="text-sm text-gray-500 mb-6">Masuk ke JaringID sekarang</p>

        <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email"
                    class="w-full px-4 py-2 mt-1 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="Masukkan email Anda" required>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 mt-1 border rounded-md focus:ring focus:ring-blue-300 focus:outline-none"
                    placeholder="Masukkan password Anda" required>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-2 text-white bg-customBlue rounded-full hover:bg-customBlueHover focus:outline-none focus:ring focus:ring-blue-300">
                Login
            </button>
        </form>

        <!-- Footer -->
        <p class="mt-4 text-center text-sm text-gray-500">
            Belum mempunyai akun?
            <a href="{{ route('web.register') }}" class="text-customBlue hover:underline">Sign Up</a>
        </p>
    </div>
</body>

</html>