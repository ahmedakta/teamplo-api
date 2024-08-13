<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Content extends Model
{
    use HasFactory , Sluggable;
    protected $fillable = [
        'category_id',
        'user_id',
        'type_id',
        'content_title',
        'content_image',
        'content_body',
        'slug',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'status',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'content_title'
            ]
        ];
    }


    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Content::class, 'parent_id');
    }
}
