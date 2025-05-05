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
        'nameClub',
        'image',
        'joiningDate',
        'exitDate',
        'place',
        'categoryType',
    ];


    public function user()
    {
        return $this->belongsTo(User::class); 
    }

}
