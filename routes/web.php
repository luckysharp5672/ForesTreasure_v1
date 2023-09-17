<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForestController;
use App\Http\Controllers\ForestInfoController;
use App\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ForestController::class, 'index'])->middleware(['auth']);

Route::post('forests', [ForestController::class, 'store']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/forest/detail/{id}', [ForestInfoController::class, 'detail'])->name('forest.detail');

Route::post('/forestinformation/import', [ForestInfoController::class, 'import'])->name('forestinformation.import');

Route::post('/upload', [VideoController::class, 'upload'])->name('video.upload');

require __DIR__.'/auth.php';
