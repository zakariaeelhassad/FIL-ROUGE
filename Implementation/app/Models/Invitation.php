<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'joueur_id',
        'status', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'club_id');
    }

    public function club()
    {
        return $this->belongsTo(ClubAdminProfile::class, 'club_id');
    }

    public function joueur()
    {
        return $this->belongsTo(JoueurProfile::class, 'joueur_id');
    }
}