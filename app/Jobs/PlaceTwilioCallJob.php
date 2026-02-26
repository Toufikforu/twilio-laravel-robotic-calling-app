<?php

namespace App\Jobs;

use App\Models\CallLead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PlaceTwilioCallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }

    public function handle(): void
    {
        \Log::info("Job running for Lead ID: " . $this->leadId);

        $lead = CallLead::find($this->leadId);

        if (!$lead) {
            \Log::info("Lead not found.");
            return;
        }

        // 🔥 TEST ONLY — no Twilio yet
        $lead->update([
            'status' => 'completed',
            'call_date' => now(),
        ]);

        \Log::info("Lead marked completed: " . $this->leadId);
    }
}