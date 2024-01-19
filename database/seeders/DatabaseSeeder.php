<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Game;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Follower;
use App\Models\Like;
use Database\Factories\FollowerFactory;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {

        if (config('database.default') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        }

        Follower::truncate();
        User::truncate();
        Post::truncate();
        Game::truncate();
        Category::truncate();

        if (config('database.default') == 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        User::factory()
            ->count(20)
            ->hasPosts(3)
            ->create();

        // Create or retrieve categories
        $bugsCategory = Category::firstOrCreate(['title' => 'Bugs']);
        $upcomingVersionsCategory = Category::firstOrCreate(['title' => 'Upcoming versions']);

        // Create or retrieve games
        $modernWarfare = Game::firstOrCreate(['title' => 'Modern Warfare']);
        $blackOps = Game::firstOrCreate(['title' => 'Black Ops']);
        $advancedWarfare = Game::firstOrCreate(['title' => 'Advanced Warfare']);

        // Attach categories to posts
        Post::factory()
            ->count(6)
            ->for(User::factory())
            ->for($modernWarfare)
            ->for($bugsCategory)
            ->create();

        Post::factory()
            ->count(6)
            ->for(User::factory())
            ->for($blackOps)
            ->for($upcomingVersionsCategory)
            ->create();

        Post::factory()
            ->count(6)
            ->for(User::factory())
            ->for($advancedWarfare)
            ->for($upcomingVersionsCategory)
            ->create();

            Comment::factory()
            ->count(6)
            ->for(User::factory())
            ->for(Post::factory())
            ->create();

            Like::factory()
            ->count(6)
            ->for(User::factory())
            ->for(Post::factory())
            ->create();

            $users = User::all();

  // ...

foreach ($users as $user) {
    $followersCount = rand(5, 10);

    // Create followers for the user
    FollowerFactory::new()->times($followersCount)->create([
        'user_id' => $user->id,
        'follower_id' => $users->except($user->id)->random()->id,
    ]);

    $followingCount = rand(5, 10);

    foreach (range(1, $followingCount) as $i) {
        $followingUser = $users->except($user->id)->random();

        if (!$user->isFollowing($followingUser->id)) {
            FollowerFactory::new()->create([
                'user_id' => $user->id,
                'follower_id' => $followingUser->id,
            ]);
        }
    }
}

// ...

    }
}
