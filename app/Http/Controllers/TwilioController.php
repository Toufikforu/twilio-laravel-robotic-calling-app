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
        $lead = CallLead::with('campaign.script')
            ->find($request->lead_id);

        $response = new VoiceResponse();

        if (!$lead || !$lead->campaign || !$lead->campaign->script) {
            $response->say("No script found.", ['voice' => 'alice']);
        } else {

            // Get script content from database
            $scriptText = $lead->campaign->script->content;

            // Optional: replace placeholders
            $scriptText = str_replace(
                ['{first_name}', '{last_name}'],
                [$lead->first_name, $lead->last_name],
                $scriptText
            );

            $response->say($scriptText, ['voice' => 'alice']);
        }

        return response($response, 200)
            ->header('Content-Type', 'text/xml');
    }

    public function statusCallback(Request $request)
    {
        \Log::info('Twilio status callback received', $request->all());

        $leadId = $request->query('lead_id');
        $callStatus = $request->input('CallStatus');

        if ($leadId) {
            $lead = CallLead::find($leadId);

            if ($lead) {
                $lead->update([
                    'status' => $callStatus,
                    'call_date' => now(),
                ]);
            }
        }

        return response('OK', 200);
    }
}