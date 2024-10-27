<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MainPageController;
use Illuminate\Support\Facades\Route;
use App\Services\NewsApiService; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::get('/hello', function () {
    $endpoint = 'everything'; // You can change the endpoint as needed
    $options = [
        'q'=>'nicht',
        'Language'=>'de',
    ];

    // Make the API call using the service
    $response = NewsApiService::getNewsArticles($endpoint, $options);

    // Encode the PHP array (which is already decoded from JSON) back to pretty JSON
    $prettyJson = json_encode($response, JSON_PRETTY_PRINT);

    return response($prettyJson)->header('Content-Type', 'text/plain');
});

//|--------------------------------------------------------------------------
//| ROOT ROUTE
//|--------------------------------------------------------------------------
Route::get('/', [MainPageController::class, 'index'])->name('mainPage');
Route::post('/', [MainPageController::class, 'handleRequest'])->name('newsResponse');


//|--------------------------------------------------------------------------
//| AUTHENTICATION
//|--------------------------------------------------------------------------
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//|--------------------------------------------------------------------------
//| ADMIN PERMISSIONS
//|--------------------------------------------------------------------------
Route::middleware(['admin'])->group(function () {
    // Your admin-only routes here
    Route::get('/admin/view_users', [AdminController::class, 'show_users']); // Controller not implemented
    Route::get('/admin/view_users/{id}', [AdminController::class, 'show_user']); // Controller not implemented
    Route::delete('/admin/view_users/{id}', [AdminController::class, 'destroy']); // Controller not implemented
    Route::put('/admin/view_users/{id}', [AdminController::class, 'update']); // Controller not implemented
});
