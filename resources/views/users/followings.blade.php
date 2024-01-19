@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-4">{{ $user->getFullName() }}'s Followers</h1>

        <ul class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($followings as $following)
                <li class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded overflow-hidden hover:shadow-lg">
                    <div class="p-4">
                        <img class="w-16 h-16 rounded-full mb-2 object-cover" src="{{ $following->profile_image }}" alt="{{ $following->getFullName() }}">
                        <h2 class="text-lg font-semibold mb-2">{{ $following->getFullName() }}</h2>
                        <p class="text-gray-600 dark:text-gray-400">{{ $following->username }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
