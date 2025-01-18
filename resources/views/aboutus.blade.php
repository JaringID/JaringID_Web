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
    <style>

    </style>
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

    <!-- About Us -->
    <section class="container mx-auto px-4 max-w-screen-xl py-16 md:py-24">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12 lg:gap-16">
            <div class="md:w-1/2 flex justify-center">
                <div class="w-full max-w-md">
                    <img src="https://i.imgur.com/WbQnbas.png" alt="About Us"
                        class="w-full h-auto object-cover rounded-lg">
                </div>
            </div>
            <div class="md:w-1/2">
                <div class="text">
                    <span class="text-gray-500 border-b-2 border-customBlue uppercase text-sm">About us</span>
                    <h2 class="my-4 font-bold text-2xl md:text-3xl lg:text-4xl">
                        About <span class="text-customBlue">Our Company</span>
                    </h2>
                    <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                        JaringID adalah sebuah startup teknologi yang berfokus pada digitalisasi sektor tambak udang di
                        Indonesia. Platform ini dikembangkan oleh 5 Mahasiswa dari Politeknik Negeri Bengkalis yang saat
                        ini
                        sedang berada di Semester 5.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section id="our-team" class="bg-gray-100 py-16 md:py-32">
        <div class="container mx-auto px-4 max-w-screen-xl">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12 text-customBlue">
                Meet Our Team
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 md:gap-8">
                <!-- Team Member Card Template -->
                <div class="team-member-card bg-white rounded-lg shadow-md p-4 md:p-6 text-center 
                transform transition-all duration-300 hover:-translate-y-4 hover:shadow-xl">
                    <div class="relative mb-4 overflow-hidden rounded-full">
                        <img src="assets/Asyraf.jpg" alt="Team Member"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-customBlue bg-opacity-0 group-hover:bg-opacity-20 
                        transition-all duration-300"></div>
                    </div>
                    <h3 class="text-base md:text-xl font-semibold mb-1 md:mb-2">
                        Muhammad Asyraf Pratama
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Project Manager
                    </p>
                </div>

                <!-- Team Member 2 -->
                <div class="team-member-card bg-white rounded-lg shadow-md p-4 md:p-6 text-center 
                transform transition-all duration-300 hover:-translate-y-4 hover:shadow-xl">
                    <div class="relative mb-4 overflow-hidden rounded-full">
                        <img src="assets/Frans.jpg" alt="Team Member"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-customBlue bg-opacity-0 group-hover:bg-opacity-20 
                        transition-all duration-300"></div>
                    </div>
                    <h3 class="text-base md:text-xl font-semibold mb-1 md:mb-2">
                        Frans Damai Zalukhu
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Fullstack Engineer
                    </p>
                </div>

                <!-- Team Member 3 -->
                <div class="team-member-card bg-white rounded-lg shadow-md p-4 md:p-6 text-center 
                transform transition-all duration-300 hover:-translate-y-4 hover:shadow-xl">
                    <div class="relative mb-4 overflow-hidden rounded-full">
                        <img src="assets/Aldi.jpg" alt="Team Member"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-customBlue bg-opacity-0 group-hover:bg-opacity-20 
                        transition-all duration-300"></div>
                    </div>
                    <h3 class="text-base md:text-xl font-semibold mb-1 md:mb-2">
                        M. Aldi Mahendra
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Frontend Engineer
                    </p>
                </div>

                <!-- Team Member 4 -->
                <div class="team-member-card bg-white rounded-lg shadow-md p-4 md:p-6 text-center 
                transform transition-all duration-300 hover:-translate-y-4 hover:shadow-xl">
                    <div class="relative mb-4 overflow-hidden rounded-full">
                        <img src="assets/Rizqo.jpg" alt="Team Member"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-customBlue bg-opacity-0 group-hover:bg-opacity-20 
                        transition-all duration-300"></div>
                    </div>
                    <h3 class="text-base md:text-xl font-semibold mb-1 md:mb-2">
                        Rizqo Sahala Putra
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        Backend Engineer
                    </p>
                </div>

                <!-- Team Member 5 -->
                <div class="team-member-card bg-white rounded-lg shadow-md p-4 md:p-6 text-center 
                transform transition-all duration-300 hover:-translate-y-4 hover:shadow-xl">
                    <div class="relative mb-4 overflow-hidden rounded-full">
                        <img src="assets/Firman.jpg" alt="Team Member"
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-customBlue bg-opacity-0 group-hover:bg-opacity-20 
                        transition-all duration-300"></div>
                    </div>
                    <h3 class="text-base md:text-xl font-semibold mb-1 md:mb-2">
                        Muhammad Firmansyah
                    </h3>
                    <p class="text-xs md:text-sm text-gray-600">
                        UI/UX Designer
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