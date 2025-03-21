<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $table = 'certification';

    protected $fillable = ['profil_joueur_id' , 'title' , 'content' , 'creation_date'];


    public function profilJoueur()
    {
        return $this->belongsTo(JoueurProfile::class);
    }

}
