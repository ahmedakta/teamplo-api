<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    const TODO = 4;
    const INPROGRESS = 3;
    const PENDING = 2;
    const COMPLETED = 1;
    const CANCELLED = 0;
    protected $fillable = [
        'name',
        'project_id',
        'parent_id',
        'description',
        'status',
    ];

    public function project()
    {
        $this->belongsTo(Project::class , 'project_id');
    }

    public function childTasks()
    {
        $this->hasMany(Task::class , 'parent_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopeCompletedTasks($query)
    {
        return $query->where('status' , 1);
    }
}
