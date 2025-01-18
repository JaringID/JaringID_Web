<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-poppins">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 flex items-center justify-between px-4 py-4 bg-white shadow-md">
        <div class="container mx-auto px-4 max-w-screen-xl flex items-center justify-between">
            <div class="flex items-center">
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

            <div class="hidden md:flex items-center space-x-8">
                <ul class="flex space-x-6 text-gray-600">
                    <li><a href="/" class="text-sm hover:text-customBlue">Home</a></li>
                    <li><a href="{{ route('aboutus') }}" class="text-sm hover:text-customBlue">Tentang Kami</a></li>
                </ul>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm text-white bg-customBlue rounded-full hover:bg-customBlueHover">
                    Daftar
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden">
                <button id="mobile-menu-toggle" class="text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="md:hidden hidden bg-white shadow-md">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <ul class="py-4 space-y-2">
                <li><a href="/" class="block text-sm text-gray-600 hover:text-customBlue">Home</a></li>
                <li><a href="{{ route('aboutus') }}" class="text-sm hover:text-customBlue">Tentang Kami</a></li>
                <li>
                    <a href="{{ route('register') }}"
                        class="block text-center text-sm px-4 py-2 text-white bg-customBlue rounded-full hover:bg-customBlueHover">
                        Sign Up
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <section class="container mx-auto px-4 max-w-screen-xl py-16 md:py-32 relative">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Top left decorations -->
            <svg class="absolute top-0 left-0 w-20 h-20 sm:w-24 sm:h-24 md:w-32 md:h-32" viewBox="0 0 100 100">
                <circle class="decoration-circle custom-blue-30" cx="10" cy="10" r="8" fill="currentColor" />
                <circle class="decoration-dot custom-blue-40" cx="30" cy="20" r="4" fill="currentColor" />
                <circle class="decoration-dot custom-blue-50" cx="15" cy="35" r="6" fill="currentColor" />
            </svg>

            <!-- Top right decorations -->
            <svg class="absolute top-0 right-0 w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40" viewBox="0 0 100 100">
                <path class="decoration-circle custom-blue-20"
                    d="M70 20 Q90 20 90 40 Q90 60 70 60 Q50 60 50 40 Q50 20 70 20" fill="currentColor" />
                <circle class="decoration-dot custom-blue-40" cx="80" cy="30" r="5" fill="currentColor" />
            </svg>

            <!-- Bottom left decorations -->
            <svg class="absolute bottom-0 left-0 w-32 h-32 sm:w-40 sm:h-40 md:w-48 md:h-48" viewBox="0 0 100 100">
                <path class="decoration-circle custom-blue-20"
                    d="M20 60 Q40 60 40 80 Q40 100 20 100 Q0 100 0 80 Q0 60 20 60" fill="currentColor" />
                <circle class="decoration-dot custom-blue-30" cx="25" cy="75" r="3" fill="currentColor" />
            </svg>
        </div>

        <!-- Main content -->
        <div class="flex flex-col-reverse md:flex-row items-center gap-8 sm:gap-12 md:gap-16 lg:gap-20 relative">
            <div class="md:w-1/2 text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-bold text-customBlue mb-4 font-poppins">
                    Selamat Datang di JaringID
                </h1>
                <p class="text-gray-600 text-base md:text-lg mb-6 font-poppins">
                    Optimalkan Tambak Udang Anda dengan JaringID, Platform berbasis digital yang efisien dan mudah
                    digunakan.
                </p>
                <a href="{{route('filament.admin.auth.login')}}"
                    class="inline-block px-6 py-3 bg-customBlue text-white rounded-full hover:bg-customBlueHover transform hover:scale-105 transition-transform duration-200 font-poppins">
                    Masuk
                </a>
            </div>
            <div class="md:w-1/2 mb-8 sm:mb-10 md:mb-0 flex justify-center relative">
                <!-- Decorative circle behind image -->
                <div class="absolute inset-0 bg-customBlue/10 rounded-full transform -rotate-6 scale-90"></div>
                <!-- Main image container -->
                <div class="w-56 sm:w-64 md:w-96 h-56 sm:h-64 md:h-96 rounded-full overflow-hidden shadow-lg relative">
                    <img src="assets/Hero Image.png" alt="Hero Image" class="object-cover w-full h-full">
                </div>
                <!-- Floating dots around image -->
                <div class="absolute inset-0">
                    <div
                        class="decoration-dot absolute top-1/4 right-0 w-2 sm:w-3 h-2 sm:h-3 bg-customBlue opacity-20 rounded-full">
                    </div>
                    <div
                        class="decoration-dot absolute bottom-1/4 left-0 w-3 sm:w-4 h-3 sm:h-4 bg-customBlue opacity-30 rounded-full">
                    </div>
                    <div class="decoration-dot absolute top-0 left-1/4 w-2 h-2 bg-customBlue opacity-40 rounded-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="bg-customBlue py-16 md:py-24">
        <div class="container-custom">
            <div class="max-w-3xl mx-auto text-center space-y-6">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white">
                    Apa itu JaringID
                </h2>
                <p class="text-white text-base md:text-lg leading-relaxed">
                    Jaring.id adalah sebuah startup teknologi yang berfokus pada digitalisasi sektor tambak udang di
                    Indonesia. Platform ini menawarkan solusi Software as a Service (SaaS) untuk membantu pelaku usaha
                    tambak meningkatkan efisiensi operasional dan produktivitas.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="bg-gray-50 py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-center text-customBlue mb-12">
                Fitur
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                <!-- Feature Cards -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center 
                transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="mb-4 md:mb-6">
                        <img src="assets/Pantau.png" alt="Monitoring"
                            class="mx-auto w-12 h-12 md:w-16 md:h-16 object-contain">
                    </div>
                    <h3 class="text-base md:text-xl font-semibold text-customBlue">
                        Pantau dan Kelola Tambak
                    </h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center 
                transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="mb-4 md:mb-6">
                        <img src="assets/Pakan.png" alt="Feed Management"
                            class="mx-auto w-12 h-12 md:w-16 md:h-16 object-contain">
                    </div>
                    <h3 class="text-base md:text-xl font-semibold text-customBlue">
                        Pengelolaan Pakan yang Terkontrol
                    </h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center 
                transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="mb-4 md:mb-6">
                        <img src="assets/Keuangan.png" alt="Financial Management"
                            class="mx-auto w-12 h-12 md:w-16 md:h-16 object-contain">
                    </div>
                    <h3 class="text-base md:text-xl font-semibold text-customBlue">
                        Manajemen Keuangan Tambak
                    </h3>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 text-center 
                transform transition-all duration-300 hover:scale-105 hover:shadow-xl">
                    <div class="mb-4 md:mb-6">
                        <img src="assets/Laporan.png" alt="Reports"
                            class="mx-auto w-12 h-12 md:w-16 md:h-16 object-contain">
                    </div>
                    <h3 class="text-base md:text-xl font-semibold text-customBlue">
                        Laporan Tambak Terstruktur
                    </h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur 1: Manajemen Tambak -->
    <section class="bg-customBlue py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="order-2 md:order-1">
                    <img src="assets/Landing Pic 1.png" alt="Management" class="w-full h-auto rounded-lg object-cover">
                </div>
                <div class="order-1 md:order-2 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-white">
                        Manajemen Tambak Lebih Mudah dan Terstruktur
                    </h2>
                    <p class="text-white text-base md:text-lg leading-relaxed mb-6">
                        Platform JaringID memudahkan Anda mengelola tambak secara komprehensif.
                        Pantau kondisi tambak, catat perkembangan, dan kelola data dengan mudah
                        melalui antarmuka yang intuitif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur 2: Efisiensi dan Produktivitas -->
    <section class="bg-gray-100 py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-customBlue">
                        Efisiensi dan Produktivitas Meningkat
                    </h2>
                    <p class="text-gray-600 text-base md:text-lg leading-relaxed mb-6">
                        JaringID membantu Anda mengoptimalkan produktivitas tambak.
                        Dapatkan wawasan mendalam untuk pengambilan keputusan yang lebih cerdas.
                    </p>
                </div>
                <div>
                    <img src="assets/Landing Pic 2.png" alt="Efisiensi" class="w-full h-auto rounded-lg object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur 3: Keuangan Tambak -->
    <section class="bg-customBlue py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="order-2 md:order-1">
                    <img src="assets/Landing Pic 3.png" alt="Keuangan" class="w-full h-auto rounded-lg object-cover">
                </div>
                <div class="order-1 md:order-2 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-white">
                        Keuangan Tambak Terkelola Dengan Baik
                    </h2>
                    <p class="text-white text-base md:text-lg leading-relaxed mb-6">
                        Lacak pengeluaran, catat pendapatan, dan dapatkan laporan keuangan
                        terperinci. JaringID membantu Anda mengelola aspek finansial tambak
                        secara transparan dan akurat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section class="bg-gray-100">
        <div class="container mx-auto py-16 px-4 max-w-screen-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-8">
                <div class="mt-12 md:mt-0">
                    <img src="assets/Jaring Team.jpg" alt="About Us Image"
                        class="object-cover rounded-lg shadow-md w-full">
                </div>
                <div class="max-w-lg">
                    <h2 class="text-3xl font-extrabold text-customBlue sm:text-4xl">
                        Tentang Kami
                    </h2>
                    <p class="mt-4 text-gray-600 text-lg">
                        JaringID adalah sebuah startup teknologi yang berfokus pada digitalisasi
                        sektor tambak udang di Indonesia. Platform ini dikembangkan oleh 5 Mahasiswa
                        dari.....
                    </p>
                    <div class="mt-8">
                        <a href="{{ route('aboutus') }}" class="text-customBlue hover:text-blue-500 font-medium">
                            Lihat Selengkapnya
                            <span class="ml-2">&#8594;</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile App Section -->
    <section class="bg-customBlue py-16 md:py-24">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 items-center">
                <div class="order-2 lg:order-1 flex justify-center">
                    <img src="assets/Jaring Mobile.png" alt="Mobile App"
                        class="w-full max-w-[180px] md:max-w-[250px] lg:max-w-[300px] object-contain">
                </div>
                <div class="order-1 lg:order-2 text-center lg:text-left">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-white mb-4 md:mb-6">
                        Tersedia juga Jaring Mobile
                    </h2>
                    <p class="text-white text-base md:text-lg leading-relaxed">
                        JaringID juga tersedia dalam Aplikasi Mobile yaitu Jaring Mobile. Kini, aplikasi manajemen
                        tambak
                        ada di genggaman Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white pt-16 pb-8">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2 lg:col-span-2">
                    <img src="{{ asset('assets/Jaring.png') }}" alt="Jaring Logo" class="h-10 mb-4">
                    <p class="text-gray-600 text-sm">Transformasi Digital Tambak Indonesia</p>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-4">Contacts</h3>
                    <div class="space-y-2">
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-800 text-sm">Email:</span>
                            <a href="mailto:jaringidn@gmail.com"
                                class="text-sm text-customBlue hover:text-customBlueHover truncate">
                                jaringidn@gmail.com
                            </a>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-800 text-sm">Alamat:</span>
                            <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer"
                                class="text-sm text-customBlue hover:text-customBlueHover truncate">
                                Bengkalis, Riau, Indonesia
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Social -->
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-4">Social</h3>
                    <a href="https://www.instagram.com/jaring.idn/"
                        class="inline-block text-gray-500 hover:text-customBlue transition-colors duration-200">
                        <svg viewBox="0 0 30 30" fill="currentColor" class="h-6 w-6">
                            <circle cx="15" cy="15" r="4"></circle>
                            <path
                                d="M19.999,3h-10C6.14,3,3,6.141,3,10.001v10C3,23.86,6.141,27,10.001,27h10C23.86,27,27,23.859,27,19.999v-10C27,6.14,23.859,3,19.999,3z M15,21c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S18.309,21,15,21z M22,9c-0.552,0-1-0.448-1-1c0-0.552,0.448-1,1-1s1,0.448,1,1C23,8.552,22.552,9,22,9z">
                            </path>
                        </svg>
                    </a>
                    <p class="mt-2 text-xs text-gray-500">Ikuti juga Sosial Media Kami</p>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="pt-8 border-t border-gray-200">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-xs md:text-sm text-gray-600 text-center md:text-left w-full md:w-auto">
                        © Copyright 2025 Jaring.ID. All rights reserved.
                    </p>
                    <ul class="flex flex-wrap justify-center md:justify-end space-x-4 w-full md:w-auto">
                        <li>
                            <a href="/" class="text-xs md:text-sm text-gray-600 hover:text-customBlue">
                                F.A.Q
                            </a>
                        </li>
                        <li>
                            <a href="/" class="text-xs md:text-sm text-gray-600 hover:text-customBlue">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="/" class="text-xs md:text-sm text-gray-600 hover:text-customBlue">
                                Terms & Conditions
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
    // Mobile Menu Toggle
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenu.classList.toggle('hidden');
    });
    </script>
</body>

</html>