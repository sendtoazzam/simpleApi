<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ResponseAPI;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('tasks', [TaskController::class, 'index']);
Route::post('tasks', [TaskController::class, 'store']);
Route::get('tasks/{id}', [TaskController::class, 'getById']);
Route::put('tasks/{id}', [TaskController::class, 'update']);
Route::delete('tasks/{id}', [TaskController::class, 'delete']);
Route::put('tasks/{id}/complete', [TaskController::class, 'complete']);

// Route::middleware('api.response')->group('api/v1', function() {
//     $this->get('tasks',TaskController::class, 'index');
// });
// $app->group(['prefix' => 'api/v1', 'middleware' => ['api.response']], function($req, $res) {
//     $this->get('tasks',TaskController::class, 'index');
// });
Route::group(['middleware' => ['apiResponse']], function () {
});
