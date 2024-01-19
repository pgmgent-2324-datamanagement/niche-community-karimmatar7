<?php

use App\Models\Post;
use App\Models\User;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/posts', function (Response $response) {
//     header('Content-type: application/json');
//     $page = request('page') ?? 1;
//     $posts = \App\Models\Post::with(['user', 'category', 'game'])
//         ->orderBy('created_at', 'desc')
//         ->paginate(10, ['*'], 'page', $page);
//     return json_encode($posts);
// });


Route::get('/posts', function (Response $response) {
            header('Content-type: application/json');
            $page = request('page') ?? 1;
            $search = request('search') ;
            $posts = \App\Models\Post::query()
                ->with(['user', 'category', 'game'])
                ->orderBy('created_at', 'desc');
            if ($search) {
                $posts->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%")
                        ->orWhereHas('user', function (Builder $query) use ($search) {
                            $query->where('firstname', 'like', "%$search%");
                        });
                });
                }

            $posts = $posts->paginate(10, ['*'], 'page', $page);
            return json_encode($posts);

        });