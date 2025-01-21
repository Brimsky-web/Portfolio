<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return inertia('Welcome');
});


Route::get('/admin', function () {
    return inertia('Welcome');
});