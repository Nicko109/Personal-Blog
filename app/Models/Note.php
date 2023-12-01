<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = false;
    protected $withCount = ['comments'];

    protected $with = ['likedUsers'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'liked_notes', 'note_id', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(NoteComment::class, 'note_id', 'id');
    }

}
