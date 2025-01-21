<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Admin extends Model
{

    //admin type shit
    protected $admin = [
        'name',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    //other more stuff
    protected $projects = [
        'project_name',
        'github_repo_url',
        'technologies',
        'description',
    ];

    protected $contacts = [
        'icon',
        'platform',
        'url',
    ];

    protected $certificates = [
        'certificate_name',
        'url',
        'date',
    ];
    use HasFactory;
}
