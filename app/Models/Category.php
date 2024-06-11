<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'cateogry_description',
        'category_color',
        'configs',
        'status',
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
