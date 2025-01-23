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
    
    // Projects routes
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects/store', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/edit/{id}', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::post('/projects/update/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::get('/projects/destroy/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    
    // Certificates routes
    Route::get('/certificates/create', [CertificateController::class, 'create'])->name('certificates.create');
    Route::post('/certificates/store', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/edit/{id}', [CertificateController::class, 'edit'])->name('certificates.edit');
    Route::post('/certificates/update/{id}', [CertificateController::class, 'update'])->name('certificates.update');
    Route::get('/certificates/destroy/{id}', [CertificateController::class, 'destroy'])->name('certificates.destroy');
    
    // Contacts routes
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/edit/{id}', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::post('/contacts/update/{id}', [ContactController::class, 'update'])->name('contacts.update');
    Route::get('/contacts/destroy/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return inertia('Login');
    })->name('login');
    
    Route::post('/login', [AdminController::class, 'login'])->name('login.attempt');
    
});
