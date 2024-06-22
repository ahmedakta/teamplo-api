<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Project extends Model
{
    use HasFactory , Sluggable;
    protected $fillable = [
        'project_name',
        'slug',
        'category_id',
        'department_id',
        'project_description',
        'project_start_at',
        'project_end_at',
        'project_budget',
        'project_priority',
        'project_stage',
        'status',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'project_name'
            ]
        ];
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function priority()
    {
        return $this->belongsTo(Category::class, 'project_priority');
    }

    public function stage()
    {
        return $this->belongsTo(Category::class, 'project_stage');
    }
}
