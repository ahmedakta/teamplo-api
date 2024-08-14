<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Department extends Model
{
    use HasFactory , Sluggable;
    protected $fillable = [
        'department_name',
        'slug',
        'department_desc',
        'department_image',
        'company_id',
        'status',
    ];
    
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'department_name'
            ]
        ];
    }

    public function users()
    {
        return $this->hasMany(User::class , 'department_id');
    }
 
    public function projects()
    {
        return $this->hasMany(Project::class , 'department_id');
    }

    public function scopeProgress()
    {
        $totalCompletedTasks = 0;
        $totalTasks = 0;
    
        //  _____ get the progress of each department ____
        if ($this->projects) {
            foreach ($this->projects as $project) {
                $totalTasks += $project->tasks->count();
                $totalCompletedTasks += $project->completedTasks()->count();
            }
        }
    
        $progressValue = $totalTasks > 0 ? ($totalCompletedTasks / $totalTasks) * 100 : 0.0;
        //  _____ End pf get the progress of each department ____
    
        return $progressValue;
    }
}
