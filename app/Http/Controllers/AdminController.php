<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
class AdminController
{
    public function index()
    {
        $projects = Admin::all();
        $certificates = Admin::all();
        $contacts = Admin::all();
        return inertia('Admin', ['projects' => $projects, 'certificates' => $certificates, 'contacts' => $contacts]);
    }
}
