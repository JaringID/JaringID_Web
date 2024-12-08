<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jaring.ID</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body class="font-poppins">
    <!-- Navbar -->
    <nav class="flex items-center justify-between px-6 py-4 bg-white shadow-md">
        <!-- Logo -->
        <div class="flex items-center">
            <img src="{{ asset('assets/Jaring.png') }}" alt="Jaring Sub Main Logo">
        </div>

        <!-- Navigation Links -->
        <ul class="flex space-x-8 text-gray-600">
            <li><a href="#" class="hover:text-blue-500">Home</a></li>
            <li><a href="#" class="hover:text-blue-500">Tentang Kami</a></li>
        </ul>

        <!-- Button -->
        <a href="#" class="px-4 py-2 text-white bg-customBlue rounded-full hover:bg-customBlueHover">
            Daftar Sekarang
        </a>

    </nav>
</body>

</html>