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

Route::resource('/notes', \App\Http\Controllers\Main\Note\NoteController::class);
Route::post('/notes/{note}/toggle_like', [\App\Http\Controllers\Main\Note\NoteController::class, 'toggleLike']);
Route::post('/notes/{note}/comment', [\App\Http\Controllers\Main\Note\NoteController::class, 'comment']);
Route::get('/notes/{note}/comment', [\App\Http\Controllers\Main\Note\NoteController::class, 'commentList']);



Route::resource('/posts', \App\Http\Controllers\Main\Post\PostController::class);
Route::post('/posts/{post}/toggle_like', [\App\Http\Controllers\Main\Post\PostController::class, 'toggleLike']);
Route::post('/posts/{post}/comment', [\App\Http\Controllers\Main\Post\PostController::class, 'comment']);
Route::get('/posts/{post}/comment', [\App\Http\Controllers\Main\Post\PostController::class, 'commentList']);


Route::resource('/videos', \App\Http\Controllers\Main\Video\VideoController::class);
Route::post('/videos/{video}/toggle_like', [\App\Http\Controllers\Main\Video\VideoController::class, 'toggleLike']);
Route::post('/videos/{video}/comment', [\App\Http\Controllers\Main\Video\VideoController::class, 'comment']);
Route::get('/videos/{video}/comment', [\App\Http\Controllers\Main\Video\VideoController::class, 'commentList']);
});









Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => ['auth', 'admin.check'],
], function () {
    Route::get('/', [\App\Http\Controllers\Admin\Main\IndexController::class, 'index'])->name('main.index');

    Route::resource('/notes', \App\Http\Controllers\Admin\Note\NoteController::class);
    Route::resource('/posts', \App\Http\Controllers\Admin\Post\PostController::class);
    Route::resource('/users', \App\Http\Controllers\Admin\User\UserController::class);
    Route::resource('/videos', \App\Http\Controllers\Admin\Video\VideoController::class);
});

require __DIR__ . '/auth.php';
