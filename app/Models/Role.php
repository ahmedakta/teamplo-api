<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'configs',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
    protected function users(){
        return $this->hasMany(User::class);
    }
}
