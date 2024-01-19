<!-- followings.blade.php -->
@extends('layouts.app')

@section('content')
    <h1 class="text-lg text-center font-bold pt-8">Posts from Followings</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
        @forelse ($followingsPosts as $post)
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded overflow-hidden hover:shadow-lg">
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded overflow-hidden hover:shadow-lg">
            <a href="/post/{{ $post->id }}">
                <img class="w-full h-40 object-cover" src="{{ $post->imageUrl }}" alt="{{ $post->title }}">
            </a>
            <div class="p-4">
                <h1 class="text-lg font-semibold mb-2">
                    <a href="/post/{{ $post->id }}" class="hover:text-blue-500">{{ $post->title }}</a>
                </h1>
                <p class="text-gray-600 dark:text-gray-400">{{ $post->description }}</p>
                <div class="flex items-center mt-4">
                    <a href="/user/{{ $post->user->id }}" class="flex items-center gap-2 hover:text-blue-500">
                        <img class="rounded-full w-10 h-10" src="{{ ($post->user->profile_image) }}" alt="">
                        <p>{{ $post->user->firstname }} {{ $post->user->lastname }}</p>
                    </a>
                </div>
            </div>
        </div>            </div>
        @empty
            <p class="text-center text-gray-500">No posts from followings yet.</p>
        @endforelse
    </div>
@endsection
