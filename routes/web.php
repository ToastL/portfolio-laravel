<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    
    Route::get('projects', [ProjectController::class, 'index'])->name('projects');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('projects/{project}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('tools', [ToolController::class, 'index'])->name('tools');
    Route::post('tools', [ToolController::class, 'store'])->name('tools.store');
    Route::delete('tools/{tool}/delete', [ToolController::class, 'destroy'])->name('tools.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
