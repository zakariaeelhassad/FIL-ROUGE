<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['full_name', 'username', 'email', 'password', 'role' , 'bio', 'profile_image', 'banner_image'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function joueurProfile()
    {
        return $this->hasOne(JoueurProfile::class);
    }

    public function clubAdminProfile()
    {
        return $this->hasOne(ClubAdminProfile::class);
    }

    public function titres()
    {
        return $this->hasMany(Titre::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function commentReply()
    {
        return $this->hasMany(commentReply::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id')->where('status', 'accepted');
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'follower_id')->where('status', 'accepted');
    }

    public function pendingFollowers()
    {
        return $this->hasMany(Follow::class, 'following_id')->where('status', 'pending');
    }

    public function friends()
    {
        return $this->hasMany(Follow::class, 'follower_id')
            ->where('status', 'accepted')
            ->with('following')
            ->union(
                $this->hasMany(Follow::class, 'following_id')
                    ->where('status', 'accepted')
                    ->with('follower')
            );
    }
    public function friend()
    {
        $friends1 = $this->hasMany(Follow::class, 'follower_id')
            ->where('status', 'accepted')
            ->pluck('following_id');

        $friends2 = $this->hasMany(Follow::class, 'following_id')
            ->where('status', 'accepted')
            ->pluck('follower_id');

        return $friends1->merge($friends2);
    }

    public function isFollowing($userId)
    {
        return Follow::where('follower_id', $this->id)
                    ->where('following_id', $userId)
                    ->where('status', 'accepted')
                    ->exists();
    }

    public function chatsAsUserOne()
    {
        return $this->hasMany(Chat::class, 'user_one_id');
    }

    public function chatsAsUserTwo()
    {
        return $this->hasMany(Chat::class, 'user_two_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Get all chats for this user
    public function chats()
    {
        return Chat::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }
}
