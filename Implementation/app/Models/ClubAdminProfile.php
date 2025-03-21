<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubAdminProfile extends Model
{
    use HasFactory;

    protected $table = 'joueur_profiles';

    protected $fillable = ['user_id' , 'description' , 'ecile' , 'Tactique' , 'Gestion' , 'categoryType'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
