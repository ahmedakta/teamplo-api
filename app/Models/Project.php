<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_name',
        'project_description',
        'project_start_at',
        'project_end_at',
        'project_budget',
        'project_priority',
        'status',
    ];

    public function department()
    {
        $this->belongsTo(Department::class);
    }

    public function tasks()
    {
        $this->hasMany(Task::class);
    }
}
