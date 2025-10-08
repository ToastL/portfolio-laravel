<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects', [
            'projects' => Project::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description_nl' => 'required|string',
            'description_en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'nullable|url',
            'github_url' => 'required|url',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tools', config('filesystems.default'));
        }

        Project::create($validated);

        return redirect()->route('projects');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects');
    }
}
