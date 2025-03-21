<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'experience';

    protected $fillable = [
        'joueur_profile_id',
        'name_club',
        'image',
        'joining_date',
        'exit_date',
        'place',
        'category_type',
    ];

    public function profilJoueur()
    {
        return $this->belongsTo(JoueurProfile::class);
    }

}
