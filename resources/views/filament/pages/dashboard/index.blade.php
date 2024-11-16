<!-- resources/views/filament/pages/dashboard/index.blade.php -->

@extends('filament::layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <h1 class="text-3xl font-bold text-blue-600">Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Statistik: Jumlah Farm -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-xl font-semibold">Total Farms</h3>
                <p class="text-2xl font-bold">{{ $farmCount }}</p>
            </div>

            <!-- Statistik: Jumlah Harvest -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-xl font-semibold">Total Harvests</h3>
                <p class="text-2xl font-bold">{{ $harvestCount }}</p>
            </div>

            <!-- Statistik: Jumlah Sales -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-xl font-semibold">Total Sales</h3>
                <p class="text-2xl font-bold">{{ $salesCount }}</p>
            </div>

            <!-- Statistik: Jumlah Employees -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-xl font-semibold">Total Employees</h3>
                <p class="text-2xl font-bold">{{ $employeeCount }}</p>
            </div>

            <!-- Statistik: Jumlah Users -->
            <div class="p-6 bg-white shadow rounded-lg">
                <h3 class="text-xl font-semibold">Total Users</h3>
                <p class="text-2xl font-bold">{{ $userCount }}</p>
            </div>
        </div>

        <!-- Tambahkan grafik atau widget lainnya di sini -->
        <div class="mt-6">
            <h2 class="text-2xl font-semibold text-blue-600">Sales Over Time</h2>
            <!-- Tempatkan grafik atau chart widget di sini -->
        </div>
    </div>
@endsection
