<?php

use App\Http\Controllers\ForumController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('users', [UserController::class, 'users']);
Route::get('forum/topics', [ForumController::class, 'topics']);
Route::get('forum/topic/{id}', [ForumController::class, 'topic']);
Route::get('forum/topic/{id}/comments', [ForumController::class, 'getComments']);
Route::delete('forum/topic/comment/{id}', [ForumController::class, 'removeComment']);
Route::delete('forum/topic/{id}', [ForumController::class, 'removeTopic']);
Route::post('forum/topic', [ForumController::class, 'addTopic']);
Route::post('forum/topic/{id}/comment', [ForumController::class, 'addComment']);
