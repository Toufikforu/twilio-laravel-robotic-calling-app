<?php

namespace App\Jobs;

use App\Models\CallLead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

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
        $lead = CallLead::find($this->leadId);

        if (! $lead) {
            return;
        }

        if ($lead->campaign && $lead->campaign->status !== 'running') {
            return;
        }

        try {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $phone = preg_replace('/\D+/', '', $lead->phone);

            if (strlen($phone) === 10) {
                $phone = '+1' . $phone;
            } elseif (strlen($phone) === 11 && str_starts_with($phone, '1')) {
                $phone = '+' . $phone;
            } elseif (str_starts_with($lead->phone, '+')) {
                $phone = $lead->phone;
            } else {
                $phone = '+' . $phone;
            }

           $call = $twilio->calls->create(
                $phone,
                config('services.twilio.from'),
                [
                    'url' => rtrim(config('app.url'), '/') . '/twilio/voice?lead_id=' . $lead->id,
                    'method' => 'POST',

                    'statusCallback' => rtrim(config('app.url'), '/') . '/api/twilio/status-callback?lead_id=' . $lead->id,
                    'statusCallbackMethod' => 'POST',
                    'statusCallbackEvent' => ['initiated','ringing','answered','completed']
                ]
            );

            $lead->update([
                'phone' => $phone,
                'status' => 'calling',
                'call_sid' => $call->sid,
                'call_date' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Twilio call failed', [
                'lead_id' => $this->leadId,
                'error' => $e->getMessage(),
            ]);

            $lead->update([
                'status' => 'failed',
            ]);
        }
    }
}