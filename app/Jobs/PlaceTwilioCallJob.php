<?php

namespace App\Jobs;

use App\Models\CallLead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Client;


class PlaceTwilioCallJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $leadId;

    public function __construct(int $leadId)
    {
        $this->leadId = $leadId;
    }

    /* Handle for test mode 
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

    */



    public function handle(): void
    {
        $lead = CallLead::find($this->leadId);

        if (!$lead) {
            return;
        }

        // Stop protection
        if ($lead->campaign && $lead->campaign->status !== 'running') {
            return;
        }

        try {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $call = $twilio->calls->create(
                $lead->phone,
                config('services.twilio.from'),
                [
                    'url' => config('app.url') . '/twilio/voice?lead_id=' . $lead->id
                ]
            );

            $lead->update([
                'status' => 'calling',
                'call_date' => now(),
            ]);

        } catch (\Exception $e) {
            $lead->update([
                'status' => 'failed',
            ]);
        }
    }
}