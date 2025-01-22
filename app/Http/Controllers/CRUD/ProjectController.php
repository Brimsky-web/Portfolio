<?php

namespace App\Http\Controllers\CRUD;

use App\Models\Projects;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProjectController
{
    public function create()
    {
        return Inertia::render('Admin/Projects');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'project_name' => 'required',
            'github_repo_url' => 'required|url',
            'technologies' => 'required',
            'description' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('projects', 'public');
            $data['photo'] = $path;
        }

        Projects::create($data);

        return redirect('/admin');
    }

    public function edit($id)
    {
        $project = Projects::find($id);
        return Inertia::render('Admin/Projects', [
            'project' => [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'github_repo_url' => $project->github_repo_url,
                'technologies' => $project->technologies,
                'description' => $project->description,
                'photo' => $project->photo ? Storage::url($project->photo) : null,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $project = Projects::findOrFail($id);
        
        $data = $request->validate([
            'project_name' => 'required',
            'github_repo_url' => 'required|url',
            'technologies' => 'required',
            'description' => 'required',
            'photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($project->photo && Storage::disk('public')->exists($project->photo)) {
                Storage::disk('public')->delete($project->photo);
            }
            
            $path = $request->file('photo')->store('projects', 'public');
            $data['photo'] = $path;
        }

        $project->update($data);

        return redirect('/admin');
    }

    public function destroy($id)
    {
        $project = Projects::findOrFail($id);
        
        // Delete photo if exists
        if ($project->photo && Storage::disk('public')->exists($project->photo)) {
            Storage::disk('public')->delete($project->photo);
        }
        
        $project->delete();
        return redirect('/admin');
    }
}
