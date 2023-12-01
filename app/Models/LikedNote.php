<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LikedNote extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $guarded = false;
}
