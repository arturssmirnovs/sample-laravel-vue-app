<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function project()
    {
        return $this->hasOne(Project::class, "id", "project_id");
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
