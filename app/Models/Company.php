<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'company_desc',
        'company_phone',
        'company_email',
        'company_website',
        'company_logo',
        'company_size',
        'address',
        'address_country',
        'address_city',
        'status',
    ];
    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    // ALL PROJECTS RELATED THE COMPANY BY DEPARTMENT
    public function projects()
    {
        return $this->hasManyThrough(Project::class, Department::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function owner()
    {
        return $this->users()
        ->whereHas('roles', function($query) {
            $query->where('name', 'owner');
        })
        ->first();
    }

}
