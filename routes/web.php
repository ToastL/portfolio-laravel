<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/storage/{filename}', function ($filename) {
    $disk = Storage::disk('s3');
    if (!$disk->exists($filename)) {
        abort(404, 'File not found.');
    }

    $file = $disk->get($filename);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($file);

    return response($file, 200)
        ->header('Content-Type', $mimeType)
        ->header('Content-Disposition', 'inline; filename="' . basename($filename) . '"');
})->where('filename', '.*');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::get('projects', [ProjectController::class, 'index'])->name('projects');
    Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('projects/{project}/delete', [ProjectController::class, 'destroy'])->name('projects.destroy');

    Route::get('tools', [ToolController::class, 'index'])->name('tools');
    Route::post('tools', [ToolController::class, 'store'])->name('tools.store');
    Route::delete('tools/{tool}/delete', [ToolController::class, 'destroy'])->name('tools.destroy');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
