<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaring</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-poppins">
    <!-- Navbar -->
    <nav class="flex items-center justify-between px-24 py-4 bg-white shadow-md">
        <!-- Logo -->
        <div class="flex items-center">
            <img src="{{ asset('assets/Jaring.png') }}" alt="Jaring Sub Main Logo">
        </div>

        <!-- Navigation Links -->
        <ul class="flex space-x-8 text-gray-600">
            <li><a href="#" class="hover:text-customBlue">Home</a></li>
            <li><a href="#" class="hover:text-customBlue">Tentang Kami</a></li>
        </ul>

        <!-- Button -->
        <a href="{{ route('register') }}"
            class="px-4 py-2 text-white bg-customBlue rounded-full hover:bg-customBlueHover">
            Daftar Sekarang
        </a>


    </nav>

    <!-- Hero Section -->
    <section class="bg-white py-32 mt-0.5">
        <div class="container mx-20 px-6 flex flex-col-reverse lg:flex-row items-center">
            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold text-customBlue mb-4">
                    Selamat Datang di JaringID
                </h1>
                <p class="text-gray-600 text-lg mb-6">
                    Optimalkan Tambak Udang Anda dengan JaringID, Platform berbasis digital yang efisien dan mudah
                    digunakan.
                </p>
                <a href="{{route('filament.admin.auth.login')}}"
                    class="px-6 py-3 bg-customBlue text-white rounded-full hover:bg-customBlueHover transition-all">
                    Bergabung Sekarang
                </a>
            </div>

            <!-- Image -->
            <div class="lg:w-1/2 mb-10 lg:mb-0 flex justify-center">
                <div class="relative mx-auto w-96 h-96 rounded-full overflow-hidden shadow-lg">
                    <img src="assets/Hero Image.png" alt="Hero Image" class="object-cover w-full h-full">
                </div>
            </div>
        </div>
    </section>

    <section class="bg-customBlue py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-white mb-6">Apa itu JaringID</h2>
            <p class="text-center text-white text-lg leading-relaxed max-w-2xl mx-auto">
                Jaring.id adalah sebuah startup teknologi yang berfokus pada digitalisasi sektor tambak udang di
                Indonesia. Platform ini menawarkan solusi Software as a Service (SaaS) untuk membantu pelaku usaha
                tambak meningkatkan efisiensi operasional dan produktivitas.
            </p>
        </div>
    </section>


    <!-- Features Section -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Fitur</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="mb-4">
                        <img src="assets/Pantau.png" alt="Teeth Whitening" class="mx-auto w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-customBlue mb-2">Pantau dan Kelola Tambak</h3>
                    <!-- <p class="text-gray-600 mb-4">Let us show you how our experience.</p> -->
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="mb-4">
                        <img src="assets/Pakan.png" alt="Oral Surgery" class="mx-auto w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-customBlue mb-2">Pengelolaan Pakan yang Terkontrol</h3>
                    <!-- <p class="text-gray-600 mb-4">Let us show you how our experience.</p> -->
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="mb-4">
                        <img src="assets/Keuangan.png" alt="Painless Dentistry" class="mx-auto w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-customBlue mb-2">Manajemen Keuangan Tambak</h3>
                    <!-- <p class="text-gray-600 mb-4">Let us show you how our experience.</p> -->
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-lg shadow-lg p-6 text-center">
                    <div class="mb-4">
                        <img src="assets/Laporan.png" alt="Periodontics" class="mx-auto w-16 h-16">
                    </div>
                    <h3 class="text-xl font-semibold text-customBlue mb-2">Laporan Tambak Terstruktur</h3>
                    <!-- <p class="text-gray-600 mb-4">Let us show you how our experience.</p> -->
                </div>
            </div>
        </div>
    </section>

    <!-- Mobile Section -->
    <section class="bg-customBlue py-24 mt-0.5">
        <div class="container mx-auto px-6 flex flex-col-reverse lg:flex-row items-center">
            <!-- Image -->
            <div class="lg:w-1/2 mb-10 lg:mb-0 flex justify-center">
                <div class="relative mx-auto w-96 h-100">
                    <img src="assets/Jaring Mobile.png" alt="Hero Image" class="object-cover w-full h-full">
                </div>
            </div>

            <!-- Text Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-4">
                    Tersedia juga Jaring Mobile
                </h2>
                <p class="text-white text-lg mb-6">
                    JaringID juga tersedia dalam Aplikasi Mobile yaitu Jaring Mobile, kini aplikasi manajemen tambak ada
                    di genggaman Anda.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <div class="px-4 pt-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8">
        <div class="grid gap-10 row-gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2">
                <a href="/" aria-label="Go home" title="Company" class="inline-flex items-center">
                    <img src="{{ asset('assets/Jaring.png') }}" alt="Jaring Sub Main Logo">
                </a>
                <div class="mt-6 lg:max-w-sm">
                    <p class="text-sm text-gray-800">
                        Transformasi Digital Tambak Indonesia
                    </p>
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <p class="text-base font-bold tracking-wide text-gray-900">Contacts</p>
                <!-- <div class="flex">
                    <p class="mr-1 text-gray-800">Phone:</p>
                    <a href="tel:850-123-5021" aria-label="Our phone" title="Our phone"
                        class="transition-colors duration-300 text-deep-purple-accent-400 hover:text-deep-purple-800">850-123-5021</a>
                </div> -->
                <div class="flex">
                    <p class="mr-1 text-gray-800">Email:</p>
                    <a href="mailto:info@lorem.mail" aria-label="Our email" title="Our email"
                        class="transition-colors duration-300 text-deep-purple-accent-400 hover:text-deep-purple-800">jaringidn@gmail.com</a>
                </div>
                <div class="flex">
                    <p class="mr-1 text-gray-800">Alamat:</p>
                    <a href="https://www.google.com/maps" target="_blank" rel="noopener noreferrer"
                        aria-label="Our address" title="Our address"
                        class="transition-colors duration-300 text-deep-purple-accent-400 hover:text-deep-purple-800">
                        Bengkalis, Riau, Indonesia
                    </a>
                </div>
            </div>
            <div>
                <span class="text-base font-bold tracking-wide text-gray-900">Social</span>
                <div class="flex items-center mt-1 space-x-3">
                    <!-- <a href="/" class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                            <path
                                d="M24,4.6c-0.9,0.4-1.8,0.7-2.8,0.8c1-0.6,1.8-1.6,2.2-2.7c-1,0.6-2,1-3.1,1.2c-0.9-1-2.2-1.6-3.6-1.6 c-2.7,0-4.9,2.2-4.9,4.9c0,0.4,0,0.8,0.1,1.1C7.7,8.1,4.1,6.1,1.7,3.1C1.2,3.9,1,4.7,1,5.6c0,1.7,0.9,3.2,2.2,4.1 C2.4,9.7,1.6,9.5,1,9.1c0,0,0,0,0,0.1c0,2.4,1.7,4.4,3.9,4.8c-0.4,0.1-0.8,0.2-1.3,0.2c-0.3,0-0.6,0-0.9-0.1c0.6,2,2.4,3.4,4.6,3.4 c-1.7,1.3-3.8,2.1-6.1,2.1c-0.4,0-0.8,0-1.2-0.1c2.2,1.4,4.8,2.2,7.5,2.2c9.1,0,14-7.5,14-14c0-0.2,0-0.4,0-0.6 C22.5,6.4,23.3,5.5,24,4.6z">
                            </path>
                        </svg>
                    </a> -->
                    <a href="https://www.instagram.com/jaring.idn/"
                        class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
                        <svg viewBox="0 0 30 30" fill="currentColor" class="h-6">
                            <circle cx="15" cy="15" r="4"></circle>
                            <path
                                d="M19.999,3h-10C6.14,3,3,6.141,3,10.001v10C3,23.86,6.141,27,10.001,27h10C23.86,27,27,23.859,27,19.999v-10   C27,6.14,23.859,3,19.999,3z M15,21c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S18.309,21,15,21z M22,9c-0.552,0-1-0.448-1-1   c0-0.552,0.448-1,1-1s1,0.448,1,1C23,8.552,22.552,9,22,9z">
                            </path>
                        </svg>
                    </a>
                    <!-- <a href="/" class="text-gray-500 transition-colors duration-300 hover:text-deep-purple-accent-400">
                        <svg viewBox="0 0 24 24" fill="currentColor" class="h-5">
                            <path
                                d="M22,0H2C0.895,0,0,0.895,0,2v20c0,1.105,0.895,2,2,2h11v-9h-3v-4h3V8.413c0-3.1,1.893-4.788,4.659-4.788 c1.325,0,2.463,0.099,2.795,0.143v3.24l-1.918,0.001c-1.504,0-1.795,0.715-1.795,1.763V11h4.44l-1,4h-3.44v9H22c1.105,0,2-0.895,2-2 V2C24,0.895,23.105,0,22,0z">
                            </path>
                        </svg>
                    </a> -->
                </div>
                <p class="mt-4 text-sm text-gray-500">
                    Ikuti juga Sosial Media Kami
                </p>
            </div>
        </div>
        <div class="flex flex-col-reverse justify-between pt-5 pb-10 border-t lg:flex-row">
            <p class="text-sm text-gray-600">
                © Copyright 2025 Jaring.ID. All rights reserved.
            </p>
            <ul class="flex flex-col mb-3 space-y-2 lg:mb-0 sm:space-y-0 sm:space-x-5 sm:flex-row">
                <li>
                    <a href="/"
                        class="text-sm text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400">F.A.Q</a>
                </li>
                <li>
                    <a href="/"
                        class="text-sm text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400">Privacy
                        Policy</a>
                </li>
                <li>
                    <a href="/"
                        class="text-sm text-gray-600 transition-colors duration-300 hover:text-deep-purple-accent-400">Terms
                        &amp; Conditions</a>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>