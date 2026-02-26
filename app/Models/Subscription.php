<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Plan;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantrity',
        'trial_ends_at',
        'ends_at',
    ];

    // public function plan()
    // {
    //     return $this->hasOne(Plan::class, 'stripe_plan','stripe_price');
    // }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'type', 'id');
    }

}
