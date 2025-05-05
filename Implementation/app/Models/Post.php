<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = ['content' , 'image','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reported_id');
    }

    public function reportedReports()
    {
        return $this->hasMany(Report::class, 'reported_id');
    }


}
