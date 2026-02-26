<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'user_id',
        'script_id',
        'name',
        'status',
        'total_leads',
        'queued_leads',
        'completed_leads',
        'failed_leads',
        'started_at',
        'stopped_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'stopped_at' => 'datetime',
    ];

    public function script()
    {
        return $this->belongsTo(Script::class);
    }

    public function leads()
    {
        return $this->hasMany(CallLead::class);
    }
}