<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoueurProfile extends Model
{
    use HasFactory;

    protected $table = 'joueur_profiles';

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

}
