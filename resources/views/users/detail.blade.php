@extends('../layouts.app')

@section('content')
    <div class="flex flex-col items-center p-8">
        <img class="w-32 h-32 rounded-full mb-4" src="{{ $user->profile_image }}" alt="{{ $user->firstname }} {{ $user->lastname }}">
        
        <div class="text-center">
            <h1 class="text-3xl font-bold">{{ $user->firstname }} {{ $user->lastname }}</h1>
            <p class="text-gray-500">{{ $user->username }}</p>
        </div>

        <div class="mt-4 text-gray-600 space-y-2">
            <div class="flex items-center space-x-2">
                <span class="font-bold">Name:</span>
                <p>{{ $user->firstname }} {{ $user->lastname }}</p>
            </div>

            <div class="flex items-center space-x-2">
                <span class="font-bold">Username:</span>
                <p>{{ $user->username }}</p>
            </div>

            <div class="flex items-center space-x-2">
                <span class="font-bold">Date of Birth:</span>
                <p>{{ $user->date_of_birth }}</p>
            </div>

            <div class="flex items-center space-x-2">
                <span class="font-bold">Gender:</span>
                <p>{{ $user->gender }}</p>
            </div>
        </div>
    </div>

    <div class="my-4 flex justify-center">
    @if(auth()->user() && auth()->user()->id !== $user->id)
        <form id="followForm" action="{{ route('user.follow', $user->id) }}" method="POST">
            @csrf
            @method('POST')
            <button id="followButton" type="button" class="bg-blue-500 text-white px-4 py-2 rounded">
                @if(auth()->user()->followings->contains($user))
                    Unfollow
                @else
                    Follow
                @endif
            </button>
        </form>

        <script>
            document.getElementById('followButton').addEventListener('click', function () {
                let confirmMessage = "Are you sure you want to ";

                if (document.getElementById('followButton').innerText.trim() === 'Unfollow') {
                    confirmMessage += 'unfollow this user?';

                    if (confirm(confirmMessage)) {
                        document.getElementById('followForm').action = "{{ route('user.unfollow', $user->id) }}";
                        document.getElementById('followForm').submit();
                    }
                } else {
                    document.getElementById('followForm').action = "{{ route('user.follow', $user->id) }}";
                    document.getElementById('followForm').submit();
                }
            });
        </script>
    @endif
</div>

<div class="my-4 flex justify-center gap-4">
@if(auth()->user() && auth()->user()->id !== $user->id)
    <a href="{{ route('user.followers', $user->id) }}">Followers {{ $user->followers->count() }}</a>
    <a href="{{ route('user.followings', $user->id) }}">Followings {{ $user->followings->count() }}</a>
@endif
</div>

    <h1 class="text-2xl font-bold mb-4 text-center">{{ $user->firstname }} Posts</h1>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($user->posts as $post)
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded overflow-hidden hover:shadow-lg">
                <a href="/post/{{ $post->id }}">
                    <img class="w-full h-40 object-cover" src="{{ $post->image }}" alt="{{ $post->title }}">
                </a>
                <div class="p-4">
                    <h1 class="text-lg font-semibold mb-2">
                        <a href="/post/{{ $post->id }}" class="hover:text-blue-500">{{ $post->title }}</a>
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $post->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection
