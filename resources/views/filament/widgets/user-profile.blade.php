<div class="bg-white shadow rounded-lg p-4">
    <div class="flex items-center space-x-4">
        @if ($profile_picture)
            <img src="{{ asset('storage/' . $profile_picture) }}" alt="Profile Picture" class="w-16 h-16 rounded-full">
        @else
            <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                <span class="text-gray-500 text-xl font-semibold">
                    {{ substr($name, 0, 1) }}
                </span>
            </div>
        @endif

        <div>
            <h3 class="text-lg font-semibold">{{ $name }}</h3>
            <p class="text-gray-600">{{ $email }}</p>
            <p class="text-sm text-gray-500 capitalize">Role: {{ $role }}</p>
        </div>
    </div>
</div>
