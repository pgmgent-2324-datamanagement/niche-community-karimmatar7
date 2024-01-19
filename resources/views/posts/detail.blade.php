@extends('../layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="p-8 shadow-md">
            <div class="flex items-center justify-between">
                <div class="flex">
                <a href="/user/{{ $post->user->id }}" class="flex items-center">
                    <img class="w-12 h-12 rounded-full" src="{{ Storage::url($post->user->profile_image) }}" alt="{{ $post->user->firstname }}">
                    </a>
                    <div class="ml-4">
                        <h1 class="text-3xl font-bold text-black">{{ $post->title }}</h1>
                        <a href="/user/{{$post->user->id}}" class="text-sm text-black">{{ $post->user->firstname }} {{ $post->user->lastname }}</a>
                    </div>
                    </div>

                <div class="flex items-center" style="gap: 1rem;">
                    @if ($post->user_id === auth()->id())
                        <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 hover:underline focus:outline-none">
                            Edit Post
                        </a>
                    @endif
                    @if ($post->likes->contains(auth()->id()))
                        <form style="margin: 0;" action="{{ route('posts.toggleLike', $post->id) }}" method="post">
                            @csrf
                            @method('POST')
                            <button style="margin: 0;" type="submit" class="text-red-500 hover:underline focus:outline-none">
                                Unlike
                            </button>
                        </form>
                    @else
                        <form style="margin: 0;" action="{{ route('posts.toggleLike', $post->id) }}" method="post">
                            @csrf
                            @method('POST')
                            <button type="submit" class="text-blue-500 hover:underline focus:outline-none">
                                Like
                            </button>
                        </form>
                    @endif

                    <div class="flex items-center ml-4 text-gray-500">
                        <span class="mr-1">{{ $post->likes->count() }}</span>
                        <span>{{ Str::plural('like', $post->likes->count()) }}</span>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <img class="w-full h-64 object-cover rounded-md" src="{{ $post->imageUrl }}" alt="{{ $post->title }}">
            </div>

            <div class="mt-6">
                <p class="text-lg text-black">{{ $post->description }}</p>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold text-black">Comments</h2>
                <!-- Comment form -->
                <form action="{{ route('posts.addComment', $post->id) }}" method="post" class="mt-4">
                    @csrf
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Add a Comment</label>
                        <textarea name="comment" id="comment" rows="3" class="mt-1 p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-30 dark:text-gray-300"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                            Add Comment
                        </button>
                    </div>
                </form>

                <!-- Display comments -->
                @forelse ($comments as $comment)
                    <div class="flex items-start mt-4">
                        <a href="/user/{{$comment->user->id}}">
                        <img class="w-10 h-10 rounded-full" src="{{ Storage::url($comment->user->profile_image) }}" alt="{{ $comment->user->firstname }}">

                        </a>
                        <div class="ml-4">
                            <a href="/user/{{$comment->user->id}}" class="text-blue">{{ $comment->user->firstname }} {{ $comment->user->lastname }}</a>
                            <p class="text-black">{{ $comment->comment }}</p>
                            <p class="text-gray-500 text-xs">{{ $comment->created_at->diffForHumans() }}</p>
                            @if(auth()->id() === $comment->user_id)
                                <div class="flex items-center space-x-4 mt-2" style="gap: 1rem;">
                                    <button onclick="toggleEditForm('{{ $comment->id }}')" class="text-blue-500 hover:underline focus:outline-none">
                                        Edit
                                    </button>
                                    <form style="margin: 0;" action="{{ route('posts.deleteComment', $comment->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="margin: 0;" class="text-red-500 hover:underline focus:outline-none">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                <form id="editForm{{ $comment->id }}" action="{{ route('posts.updateComment', $comment->id) }}" method="post" class="hidden mt-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="comment" class="p-2 w-full border rounded-md focus:outline-none focus:ring focus:border-blue-300" value="{{ $comment->comment }}">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                                        Update
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-300">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection

<script>
    function toggleEditForm(commentId) {
        const editForm = document.getElementById(`editForm${commentId}`);
        editForm.classList.toggle('hidden');
    }
</script>