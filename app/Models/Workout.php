<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        "workout",
        "work",
        "rest",
        "rounds",
        "name",
        "exercises",
        "total_duration",
        "finished_at",
        "real_total_duration",
        "note"
    ];
}