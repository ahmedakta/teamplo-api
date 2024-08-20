<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    protected $fillable = [
        'tag_name',
        'tag_description',
        'tag_configs',
        'status',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
