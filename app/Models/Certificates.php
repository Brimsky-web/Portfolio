<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    protected $table = 'certificates';

    protected $fillable = [
        'certificate_name',
        'provider',
        'url',
        'date',
    ];
}
