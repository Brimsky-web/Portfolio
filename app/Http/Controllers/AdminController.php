<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Projects;
use App\Models\Certificates;
use App\Models\Contacts;

class AdminController extends Controller
{
    public function show()
    {
        return Inertia::render('Admin', [
            'projects' => Projects::all()->map(function($project) {
                return [
                    'id' => $project->id,
                    'project_name' => $project->project_name,
                    'github_repo_url' => $project->github_repo_url,
                    'technologies' => $project->technologies,
                    'description' => $project->description,
                ];
            }),
            'certificates' => Certificates::all()->map(function($cert) {
                return [
                    'id' => $cert->id,
                    'certificate_name' => $cert->certificate_name,
                    'url' => $cert->url,
                    'date' => $cert->date,
                ];
            }),
            'contacts' => Contacts::all()->map(function($contact) {
                return [
                    'id' => $contact->id,
                    'platform' => $contact->platform,
                    'icon' => $contact->icon,
                    'url' => $contact->url,
                ];
            })
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/admin');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        } catch (\Exception $e) {
            // \Log::error('Login error: ' . $e->getMessage());
            return back()->withErrors([
                'email' => 'An error occurred during login. Please try again.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
