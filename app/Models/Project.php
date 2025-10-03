<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description_nl',
        'description_en',
        'image',
        'url',
        'github_url',
    ];
}
