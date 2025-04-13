<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Titre extends Model
{
    use HasFactory;

    // Champs autorisés pour l'insertion en masse (mass assignment)
    protected $fillable = [
        'user_id',
        'nom_titre',
        'nombre',
        'description',
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

