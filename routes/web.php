<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





Route::middleware('auth')->group(function () {
Route::get('/main', [\App\Http\Controllers\Main\Main\IndexController::class, 'index'])->name('main.index');

Route::resource('/projects', \App\Http\Controllers\Main\Project\ProjectController::class);


Route::resource('/posts', \App\Http\Controllers\Main\Post\PostController::class);
Route::post('/posts/{post}/comment', [\App\Http\Controllers\Main\Post\PostController::class, 'comment']);
Route::get('/posts/{post}/comment', [\App\Http\Controllers\Main\Post\PostController::class, 'commentList']);

});









Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin.check'],
], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Main\IndexController::class, 'index'])->name('main.index');

    Route::resource('/projects', \App\Http\Controllers\Admin\Project\ProjectController::class);
    Route::resource('/posts', \App\Http\Controllers\Admin\Post\PostController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\User\UserController::class);
});

require __DIR__ . '/auth.php';
