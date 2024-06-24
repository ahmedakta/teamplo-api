<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'department_name',
        'department_desc',
        'company_id',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class , 'department_id');
    }
 
    public function projects()
    {
        return $this->hasMany(Project::class , 'department_id');
    }

    public function scopeCompletedTasks()
    {
        
    }
}
