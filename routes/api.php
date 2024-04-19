<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubjectController;


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

Route::post('subject/create', [SubjectController::class, 'store'])->name('api.subject.create');
Route::get('subject/show/{id}', [SubjectController::class, 'show'])->name('api.subject.show');
Route::put('subject/update/{id}', [SubjectController::class, 'update'])->name('api.subject.update');
Route::delete('subject/delete/{id}', [SubjectController::class, 'destroy'])->name('api.subject.destroy');