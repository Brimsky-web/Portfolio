<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CRUD\ProjectController;
use App\Http\Controllers\CRUD\CertificateController;
use App\Http\Controllers\CRUD\ContactController;
use App\Models\Projects;
use App\Models\Certificates;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return inertia('Welcome', [
        'projects' => Projects::all()->map(function($project) {
            return [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'github_repo_url' => $project->github_repo_url,
                'technologies' => $project->technologies,
                'description' => $project->description,
                'photo' => $project->photo_url,
            ];
        }),
        'certificates' => Certificates::all()->map(function($cert) {
            return [
                'id' => $cert->id,
                'certificate_name' => $cert->certificate_name,
                'provider' => $cert->provider,
                'url' => $cert->url,
                'date' => $cert->date,
            ];
        }),
        'contacts' => Contacts::all()->map(function($contact) {
            return [
                'id' => $contact->id,
                'platform' => $contact->platform,
                'url' => $contact->url,
                'icon' => $contact->icon,
            ];
        }),
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'show'])->name('admin');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return inertia('Login');
    })->name('login');
    
    Route::post('/login', [AdminController::class, 'login'])->name('login.attempt');
});

//CRUD routes
Route::get('/projects/create', [ProjectController::class, 'create']);
Route::get('/certificates/create', [CertificateController::class, 'create']);
Route::get('/contacts/create', [ContactController::class, 'create']);

Route::post('/certificates/store', [CertificateController::class, 'store']);
Route::post('/contacts/store', [ContactController::class, 'store']);

Route::get('/projects/edit/{id}', [ProjectController::class, 'edit']);
Route::get('/certificates/edit/{id}', [CertificateController::class, 'edit']);
Route::get('/contacts/edit/{id}', [ContactController::class, 'edit']);

Route::post('/certificates/update/{id}', [CertificateController::class, 'update']);
Route::post('/contacts/update/{id}', [ContactController::class, 'update']);

Route::get('/certificates/destroy/{id}', [CertificateController::class, 'destroy']);
Route::get('/contacts/destroy/{id}', [ContactController::class, 'destroy']);