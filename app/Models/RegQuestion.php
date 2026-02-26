<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RegQuestion extends Model
{
    //
    use HasFactory;

    protected $fillable = ['user_id', 'usage', 'dyes', 'trainings_taken'];

    protected $casts = [
        'trainings_taken' => 'array', // Convert JSON to array automatically
    ];
}
