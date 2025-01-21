<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
Route::get('/', function () {
    return inertia('Welcome');
});


Route::get('/admin', [AdminController::class, 'index']);
