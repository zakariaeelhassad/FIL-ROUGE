<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubAdminProfile extends Model
{
    use HasFactory;

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

    public function joueurs()
    {
        return $this->hasMany(JoueurProfile::class, 'club_id');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class, 'club_id');
    }

    public function titres()
    {
        return $this->hasMany(Titre::class);
    }
}