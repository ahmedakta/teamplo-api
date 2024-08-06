<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'project_id',
        'comment_desc',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Poject::class , 'project_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
}
