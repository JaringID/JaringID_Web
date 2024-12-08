<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - JaringID</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-poppins">
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md p-8 bg-white rounded-lg shadow">
            <h2 class="mb-2 text-2xl font-bold text-center">Buat akun</h2>
            <p class="mb-6 text-center text-gray-500">Ayo bergabung dengan JaringID sekarang</p>

            @if (session('success'))
            <div class="mb-4 text-green-500">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-4 text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('web.register.process') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block mb-2 text-sm font-medium">Nama</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="phone_number" class="block mb-2 text-sm font-medium">Nomor HP</label>
                    <input type="text" id="phone_number" name="phone_number" class="w-full px-4 py-2 border rounded"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-2 text-sm font-medium">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium">Ulangi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full px-4 py-2 border rounded" required>
                </div>
                <div class="mb-6">
                    <p class="mb-2 text-sm font-medium">Pekerjaan</p>
                    <label>
                        <input type="radio" name="role" value="owner" required> Pemilik Tambak
                    </label>
                    <label>
                        <input type="radio" name="role" value="technician" required> Teknisi
                    </label>
                    <label>
                        <input type="radio" name="role" value="worker" required> Pekerja Tambak
                    </label>
                </div>
                <button type="submit"
                    class="w-full px-4 py-2 text-white bg-customBlue rounded-full hover:bg-customBlueHover">
                    Create Account
                </button>
                <p class="mt-4 text-center text-gray-500">Sudah mempunyai akun? <a href="{{ route('login') }}"
                        class="text-customBlue hover:underline">Sign in</a></p>
            </form>
        </div>
    </div>
</body>

</html>