<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Game;
use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller {
    
    public function index($name = 'Unknown') {
        $users = User::all();
        $games = Game::all();
        $categories = Category::all();

        $search = request('search');

        $querybuilder = Post::query()->orderBy('id');

        if($search) {
            $querybuilder->where('description', 'LIKE', '%' . $search . '%')
            ->orWhere('title', 'LIKE',"%$search%")
            ->orWhereHas('user', function (Builder $query)  {
                $search = request('search');
                $query->where('firstname', 'like', "%$search%");
            });
        }
        $posts = $querybuilder->simplePaginate()->withQueryString();
        return view('welcome', [
            'name' => $name,
            'posts' => $posts,
            'users' => $users,
            'games' => $games,
            'categories' => $categories,
        ]);
    }
    
    public function PostDetail($id) {
        $post = Post::find($id);
        $comments = $post->comments;
        
        if (!$post) {
            abort(404);
        }
        
        return view('posts.detail', [
            'post' => $post,
            'comments' => $comments
        ]);
    }

    public function UserDetail($id) {
        $user = User::find($id);
        
        if (!$user) {
            abort(404);
        }
        
        return view('users.detail', [
            'user' => $user
        ]);
    }

    public function create() {
        return view('welcome');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'game_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        

        // Create a new post
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->game_id = $request->input('game_id');
        $post->category_id = $request->input('category_id');
        $post->user_id = auth()->id();
        if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('post_images', 'public');
        $post->image = $imagePath;
}

        $post->save();

        return redirect()->route('posts.detail', $post->id)
                 ->with('success', 'Post created successfully');

    }
    public function edit($id) {
        $post = Post::find($id);
    
        // Check if the logged-in user is the owner of the post
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
    
        $games = Game::all();
        $categories = Category::all();
    
        return view('posts.edit', compact('post', 'games', 'categories'));
    }
    
    public function update(Request $request, $id) {
        $post = Post::find($id);
    
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:8192',
            'game_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);
    
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->game_id = $request->input('game_id');
        $post->category_id = $request->input('category_id');
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images', 'public');
            $post->image = $imagePath;
        }
    
        $post->save();
    
        return redirect()->route('posts.detail', $post->id)
                ->with('success', 'Post updated successfully');
    }

    public function destroy($id) {
        $post = Post::find($id);
    
        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }
    
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
    
        $post->delete();
    
        return redirect()->route('post.index')->with('success', 'Post deleted successfully');
    }

    public function addComment(Request $request, $id) {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $post = Post::find($id);
    
        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }
    
        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->user_id = auth()->id();
        $comment->post_id = $post->id;
        $comment->save();
    
        return redirect()->back()->with('success', 'Comment added successfully');
    }

    public function updateComment(Request $request, $id) {
        $request->validate([
            'comment' => 'required|string|max:255',
        ]);
    
        $comment = Comment::find($id);
    
        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }
    
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
    
        $comment->comment = $request->input('comment');
        $comment->save();
    
        return redirect()->back()->with('success', 'Comment updated successfully');
    }

    public function deleteComment($id) {
        $comment = Comment::find($id);
    
        if (!$comment) {
            return redirect()->back()->with('error', 'Comment not found.');
        }
    
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }
    
        $comment->delete();
    
        return redirect()->back()->with('success', 'Comment deleted successfully');
    }
    public function follow(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'id' => 'exists:users,id|not_in:' . $request->user()->id,
        ]);
    
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
    
        if ($request->user()->followings->contains($user)) {
            return redirect()->back()->with('error', 'Already following this user');
        }
    
        $request->user()->followings()->attach($user->id);
    
        // Notify the user (example)
        // $user->notify(new FollowNotification($request->user()));
    
        return redirect()->back()->with('success', 'Successfully followed user');
    }
    
    // unfollow
    public function unfollow(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'id' => 'exists:users,id|not_in:' . $request->user()->id,
        ]);
    
        $user = User::find($id);
    
        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }
    
        if (!$request->user()->followings->contains($user)) {
            return redirect()->back()->with('error', 'Not following this user');
        }
    
        $request->user()->followings()->detach($user->id);
    
        return redirect()->back()->with('success', 'Successfully unfollowed user');
    }
    public function followers($id)
{
    $user = User::find($id);
    $followers = $user->followers;

    return view('users.followers', compact('user', 'followers'));
}

public function followings($id)
{
    $user = User::find($id);
    $followings = $user->followings;

    return view('users.followings', compact('user', 'followings'));
}
public function followingsPosts()
{
    $user = Auth::user();
    $followingsPosts = $user->followings->flatMap(function ($following) {
        return $following->posts;
    })->unique();

    return view('posts.followings', compact('followingsPosts'));
}

public function gamePosts($id)
{
    $game = Game::find($id);
    $gamePosts = $game->posts;

    return view('posts.game', compact('game', 'gamePosts'));
}

public function toggleLike(Request $request, $id)
{
    // Validate input
    $request->validate([
        'id' => 'exists:posts,id',
    ]);

    $post = Post::find($id);

    if (!$post) {
        return redirect()->back()->with('error', 'Post not found');
    }

    $user = $request->user();

    if ($user->likes->contains($post)) {
        // User has already liked the post, so unlike it
        $user->likes()->detach($post->id);
        $message = 'Successfully unliked post';
    } else {
        // User has not liked the post, so like it
        $user->likes()->attach($post->id);
        $message = 'Successfully liked post';
    }

    return redirect()->back()->with('success', $message);
}
}
