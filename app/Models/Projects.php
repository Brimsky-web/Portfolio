<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';
    protected $fillable = [
        'project_name',
        'github_repo_url',
        'technologies',
        'description',
        'photo'
    ];

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return null;
        }
        return Storage::disk('public')->url($this->photo);
    }
}
