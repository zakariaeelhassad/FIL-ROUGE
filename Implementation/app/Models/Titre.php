<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titre extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_admin_profile_id',
        'nom_titre',
        'nombre',
        'description_titre',
        'image',
    ];

    /**
     * Relation avec l'utilisateur (chaque titre appartient à un utilisateur)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

