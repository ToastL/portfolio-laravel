<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ToolController extends Controller
{
    public function index()
    {
        return Inertia::render('Tools', [
            'tools' => Tool::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|mimetypes:image/svg+xml|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('tools', config('filesystems.default'));
        }

        Tool::create($validated);

        return redirect()->route('tools');
    }

    public function destroy(Tool $tool)
    {
        $tool->delete();
        return redirect()->route('tools');
    }
}
