<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'liked_posts', 'user_id', 'post_id');

    }



    public function notes()
    {
        return $this->hasMany(Note::class, 'user_id', 'id');
    }

    public function likedNotes()
    {
        return $this->belongsToMany(Note::class, 'liked_notes', 'user_id', 'note_id');

    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'user_id', 'id');
    }

    public function likedVideos()
    {
        return $this->belongsToMany(Video::class, 'liked_videos', 'user_id', 'video_id');

    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function getIsAdminAttribute()
    {
        return $this->roles->pluck('title')->contains(Role::ROLE_ADMIN);
    }
}
