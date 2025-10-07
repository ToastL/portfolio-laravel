<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Project;
use App\Models\Tool;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('projects', function () {
    return Inertia::render('Projects', [ 'projects' => Project::all(), ]);
})->middleware(['auth','verified'])->name('projects');

Route::post('projects', function (Request $request) {
    Project::create($request->validate([
        'name' => 'required|string|max:255',
        'description_nl' => 'required|string',
        'description_en' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'url' => 'nullable|url',
        'github_url' => 'required|url',
    ]));

    return Inertia::render('Projects', [ 'projects' => Project::all(), ]);
})->middleware(['auth','verified'])->name('projects.store');

Route::delete('projects/{project}/delete', function (Project $project) {
    $project->delete();

    return Inertia::render('Projects', [ 'projects' => Project::all(), ]);
})->middleware(['auth','verified'])->name('projects.destroy');

Route::get('tools', function () {
    return Inertia::render('Tools', [ 'tools' => Tool::all() ]);
})->middleware(['auth','verified'])->name('tools');

Route::post('tools', function (Request $request) {
    Tool::create($request->validate([
        'name' => 'required|string|max:255',
        'image' => 'nullable|mimetypes:image/svg+xml|max:2048',
    ]));

    return Inertia::render('Tools', [ 'tools' => Tool::all() ]);
})->middleware(['auth','verified'])->name('tools.store');

Route::delete('tools/{tool}/delete', function (Tool $tool) {
    $tool->delete();

    return Inertia::render('Tools', [ 'tools' => Tool::all() ]);
})->middleware(['auth','verified'])->name('tools.destroy');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
