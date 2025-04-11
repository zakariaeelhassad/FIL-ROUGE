<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubAdminProfile extends Model
{
    use HasFactory;

    protected $table = 'club_admin_profiles';

    protected $fillable = [
        'user_id', 
        'description', 
        'ecile', 
        'Tactique', 
        'Gestion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class); 
    }
}