<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['user_one_id', 'user_two_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function getOtherUser($userId)
    {
        if ($this->user_one_id == $userId) {
            return $this->userTwo;
        }
        
        return $this->userOne;
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }

    public function hasUser($userId)
    {
        return $this->user_one_id == $userId || $this->user_two_id == $userId;
    }
}