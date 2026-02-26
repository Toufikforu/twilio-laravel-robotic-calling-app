<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use App\Models\CallLead;

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
}