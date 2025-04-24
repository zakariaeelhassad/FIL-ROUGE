<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSocialMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'google',
        'twitter',
        'linkedin',
        'instagram'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}