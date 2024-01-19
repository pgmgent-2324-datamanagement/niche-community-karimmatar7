@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center h-screen">
    <div class="bg-{{ Auth::user()->theme === 'dark' ? 'gray-800' : 'white' }} border rounded-md shadow-md p-8 w-full max-w-2xl">
        <h2 class="text-3xl font-bold mb-6">Edit Post</h2>
        <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-{{ Auth::user()->theme === 'dark' ? 'white' : 'gray-700' }}">Title</label>
                <input type="text" name="title" id="title" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-{{ Auth::user()->theme === 'dark' ? 'white' : 'gray-700' }}">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300"></textarea>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-{{ Auth::user()->theme === 'dark' ? 'white' : 'gray-700' }}">Select Game</label>
                <select name="game_id" id="game_id" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300">
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}">{{ $game->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-{{ Auth::user()->theme === 'dark' ? 'white' : 'gray-700' }}">Select Category</label>
                <div class="mt-1 grid grid-cols-2 gap-4">
                    @foreach ($categories as $category)
                        <label class="flex items-center space-x-2 text-{{ Auth::user()->theme === 'dark' ? 'white' : 'gray-700' }}">
                            <input type="radio" name="category_id" value="{{ $category->id }}" class="form-radio">
                            <span>{{ $category->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-{{ Auth::user()->theme === 'dark' ? 'white' : 'gray-700' }}">Image</label>
                <input type="file" name="image" id="image" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">Update Post</button>
            </div>
        </form>
    </div>
</div>
@endsection
