<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForestController;
use App\Http\Controllers\ForestInfoController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\TimberSearchController;
use App\Http\Controllers\WorkRequestController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/profile/update-work-area', [ProfileController::class, 'updateWorkArea'])->name('profile.updateWorkArea');

Route::get('/forest', [ForestController::class, 'index'])->middleware(['auth'])->name('forest.index');

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

Route::get('/timber_search', [TimberSearchController::class, 'index'])->name('timber_search');

Route::post('/timber_search/results', [TimberSearchController::class, 'searchResults'])->name('timber.search.results');

Route::get('/work_requests/create/{forestId}', [WorkRequestController::class, 'create'])->name('work_requests.create');

Route::resource('work_requests', WorkRequestController::class)->except(['create']);

Route::get('/work_requests', [WorkRequestController::class, 'index'])->name('work_requests');

Route::post('/work-requests/{id}/approve-forester', [WorkRequestController::class, 'approveForester']);

Route::post('/work-requests/{id}/approve-owner', [WorkRequestController::class, 'approveOwner']);

Route::post('/work-requests/{id}/complete', [WorkRequestController::class, 'completeWork']);

require __DIR__.'/auth.php';
