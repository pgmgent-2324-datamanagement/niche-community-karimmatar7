
@extends('layouts.app')

@section('content')
<div class="flex items-start space-x-4 mb-8">
    <div class="flex-shrink-0 border-r pr-4 sticky top-20 h-screen">
        <h2 class="text-2xl font-bold mb-4">Filter by Game</h2>
        <ul>
            @foreach ($games as $game)
                <li>
                    <a href="{{ route('posts.game', ['id' => $game->id]) }}" class="text-blue-500 hover:underline">{{ $game->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="flex-grow">
        @auth
            <div class="mb-4 mt-4">
                <div id="toggleFormButton" class="mb-4">
                    <button id="toggleForm" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Post</button>
                </div>
                <div id="createForm" class="hidden mt-4">
        <h2 class="text-xl font-bold">Create a New Post</h2>
        <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mt-2">
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" id="title" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mt-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
            </div>

            <div class="mt-2">
                <label class="block text-sm font-medium text-gray-700">Select Game</label>
                <select name="game_id" id="game_id" class="mt-1 p-2 w-full border rounded-md">
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}">{{ $game->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-2">
                <label class="block text-sm font-medium text-gray-700">Select Category</label>
                <div class="mt-1 grid grid-cols-2 gap-4">
                    @foreach ($categories as $category)
                        <label class="flex items-center space-x-2 text-gray-700">
                            <input type="radio" name="category_id" value="{{ $category->id }}" class="form-radio">
                            <span>{{ $category->title }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-2">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="mt-1 p-2 w-full border rounded-md">
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Create Post</button>
                <button type="button" id="closeForm" class="ml-2 text-gray-500">Cancel</button>
            </div>
        </form>
    </div>
            </div>
        @endauth

        <div class="mt-4">
            @auth
                <a href="{{ route('posts.followings') }}" class="bg-green-500 text-white px-4 py-2 rounded-md">View Followings' Posts</a>
            @endauth
        </div>

        <h1 class="text-lg text-center font-bold pt-8">Latest Blogs</h1>
        <div id="blogs" data-form="{{ request('search') }}">
            <!-- Posts will be dynamically added here -->
        </div>
    </div>
</div>

<script>
    const toggleButtonContainer = document.getElementById('toggleFormButton');
    const toggleButton = document.getElementById('toggleForm');
    const createForm = document.getElementById('createForm');
    const closeFormButton = document.getElementById('closeForm');

    toggleButton.addEventListener('click', () => {
        toggleButtonContainer.classList.add('hidden');
        createForm.classList.remove('hidden');
    });

    closeFormButton.addEventListener('click', () => {
        toggleButtonContainer.classList.remove('hidden');
        createForm.classList.add('hidden');
    });

</script>

@endsection


