<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallLead extends Model
{
    protected $table = 'call_leads';

    protected $fillable = ['first_name','last_name','phone','status','call_date'];

    protected $casts = [
        'call_date' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}