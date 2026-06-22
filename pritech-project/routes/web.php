<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
// Route::resource('projects', ProjectController::class);

Route::get('/dashboard', function () {

    // $projects = Project::latest()->get();
    $projects = Project::with('issues')->latest()->get();

    return view('dashboard', compact('projects'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('projects', ProjectController::class);
    Route::resource('issues', IssueController::class);
    Route::resource('tags', TagController::class);

    Route::post('/issues/{issue}/attach-tag', [IssueController::class, 'attachTag']);
Route::post('/issues/{issue}/detach-tag', [IssueController::class, 'detachTag']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
