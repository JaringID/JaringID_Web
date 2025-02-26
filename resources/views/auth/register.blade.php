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
    <div
        class="min-h-screen bg-gray-100 bg-center bg-no-repeat flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        <!-- Animated Wave Backgrounds -->
        <div class="wave-container">
            <div class="wave wave1"></div>
            <div class="wave wave2"></div>
            <div class="wave wave3"></div>
            <div class="wave wave4"></div>
        </div>
        <!-- Logo -->
        <div class="absolute top-6 right-6 sm:top-8 sm:right-8 md:top-10 md:right-10 lg:top-12 lg:left-12 z-20">
            <a href="/" class="block group relative inline-block">
                <div class="absolute -inset-1 bg-customBlue/20 
            rounded-lg 
            opacity-0 
            group-hover:opacity-100 
            transition-opacity 
            duration-300 
            blur-md"></div>
                <img src="{{ asset('assets/Jaring.png') }}" alt="JaringID Logo" class="w-20 sm:w-24 md:w-28 lg:w-32 h-auto 
                    relative 
                    transition-all 
                    duration-300 
                    group-hover:scale-105 
                    group-hover:brightness-110 
                    rounded-lg 
                    z-10">
            </a>
        </div>

        <div
            class="max-w-md w-full space-y-8 bg-white/90 backdrop-blur-sm rounded-xl shadow-lg p-6 sm:p-8 lg:p-10 relative z-10">
            <!-- Header -->
            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-bold text-customBlue mb-2">Buat Akun</h2>
                <p class="text-gray-500">Ayo bergabung dengan JaringID sekarang</p>
            </div>

            <!-- Alert Messages -->
            @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <ul class="list-disc list-inside text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <!-- Registration Form -->
            <form action="{{ url('/api-register') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-5">
                    <!-- Name Input -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" id="name" name="name"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-300 text-gray-900 focus:outline-none focus:ring-customBlue focus:border-customBlue focus:z-10 sm:text-sm"
                            required value="{{ old('name') }}" placeholder="Masukkan Nama Lengkap">
                    </div>

                    <!-- Phone Input -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                        <input type="text" id="phone_number" name="phone_number"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-300 text-gray-900 focus:outline-none focus:ring-customBlue focus:border-customBlue focus:z-10 sm:text-sm"
                            required value="{{ old('phone_number') }}" placeholder="Contoh: 081234567890">
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-300 text-gray-900 focus:outline-none focus:ring-customBlue focus:border-customBlue focus:z-10 sm:text-sm"
                            required value="{{ old('email') }}" placeholder="nama@email.com">
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-300 text-gray-900 focus:outline-none focus:ring-customBlue focus:border-customBlue focus:z-10 sm:text-sm"
                            required placeholder="Minimal 8 Karakter">
                    </div>

                    <!-- Confirm Password Input -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Ulangi
                            Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="appearance-none relative block w-full px-4 py-3 border border-gray-300 rounded-lg placeholder-gray-300 text-gray-900 focus:outline-none focus:ring-customBlue focus:border-customBlue focus:z-10 sm:text-sm"
                            required placeholder="Konfirmasi Password">
                    </div>

                    <!-- Role Selection -->
                    <div class="space-y-2">
                        <p class="block text-sm font-medium text-gray-700">Pekerjaan</p>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <label
                                class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="role" value="owner" required
                                    {{ old('role') == 'owner' ? 'checked' : '' }}
                                    class="h-4 w-4 text-customBlue focus:ring-customBlue">
                                <span class="text-sm text-gray-700">Pemilik Tambak</span>
                            </label>
                            <label
                                class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="role" value="technician" required
                                    {{ old('role') == 'technician' ? 'checked' : '' }}
                                    class="h-4 w-4 text-customBlue focus:ring-customBlue">
                                <span class="text-sm text-gray-700">Teknisi</span>
                            </label>
                            <label
                                class="flex items-center space-x-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                <input type="radio" name="role" value="worker" required
                                    {{ old('role') == 'worker' ? 'checked' : '' }}
                                    class="h-4 w-4 text-customBlue focus:ring-customBlue">
                                <span class="text-sm text-gray-700">Pekerja Tambak</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-customBlue hover:bg-customBlueHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-customBlue transition-colors duration-200">
                    Daftar
                </button>

                <!-- Sign In Link -->
                <p class="text-center text-sm text-gray-500">
                    Sudah mempunyai akun?
                    <a href="{{route('filament.admin.auth.login')}}"
                        class="font-medium text-customBlue hover:text-customBlueHover transition-colors duration-200">
                        Sign in
                    </a>
                </p>
            </form>

            <!-- Footer -->
            <footer class="bg-white pt-8 pb-8">
                <div class="container mx-auto px-4">
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex flex-col items-center space-y-4">
                            <p class="text-xs md:text-sm text-gray-600 text-center">
                                © {{ now()->year }} JaringID. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>