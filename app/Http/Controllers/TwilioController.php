<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use App\Models\CallLead;
use Illuminate\Support\Facades\Log;

class TwilioController extends Controller
{
    public function voice(Request $request)
    {
        $lead = CallLead::with('campaign.script')->find($request->lead_id);

        $response = new VoiceResponse();

        if (! $lead || ! $lead->campaign || ! $lead->campaign->script) {
            $response->say('No script found.', ['voice' => 'alice']);
        } else {
            $scriptText = $lead->campaign->script->content;

            $scriptText = str_replace(
                ['{first_name}', '{last_name}'],
                [$lead->first_name, $lead->last_name],
                $scriptText
            );

            $response->say($scriptText, ['voice' => 'alice']);
        }

        return response($response, 200)->header('Content-Type', 'text/xml');
    }

public function statusCallback(Request $request)
{
    Log::info('Twilio status callback received', [
        'lead_id' => $request->query('lead_id'),
        'call_sid' => $request->input('CallSid'),
        'call_status' => $request->input('CallStatus'),
        'call_duration' => $request->input('CallDuration'),
    ]);

    $leadId = $request->query('lead_id');

    if (! $leadId) {
        return response('Missing lead_id', 200);
    }

    $lead = CallLead::find($leadId);

    if (! $lead) {
        return response('Lead not found', 200);
    }

    $updateData = [
        'status' => $request->input('CallStatus'),
        'call_sid' => $request->input('CallSid'),
        'call_date' => now(),
    ];

    if ($request->filled('CallDuration')) {
        $updateData['duration'] = (int) $request->input('CallDuration');
    }

    $lead->update($updateData);

    return response('OK', 200);
}
}