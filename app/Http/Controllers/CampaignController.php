<?php

namespace App\Http\Controllers;

use App\Jobs\PlaceTwilioCallJob;
use App\Models\Campaign;
use App\Models\CallLead;
use App\Models\Script;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $campaigns = Campaign::with('script')
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->orderByDesc('id')
            ->get();

        $scripts = Script::when($userId, fn($q) => $q->where('user_id', $userId))
            ->orderByDesc('id')
            ->get();

        return view('user.pages.campaigns', compact('campaigns', 'scripts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'script_id' => ['required', 'exists:scripts,id'],
        ]);

        $data['user_id'] = Auth::id();
        $data['status'] = 'draft';

        $campaign = Campaign::create($data);

        return back()->with('success', 'Campaign created.');
    }

    public function start(Campaign $campaign)
    {
        // Ownership check (MVP)
        if ($campaign->user_id && $campaign->user_id !== Auth::id()) {
            abort(403);
        }

        if (in_array($campaign->status, ['running'], true)) {
            return back()->with('error', 'Campaign is already running.');
        }

        DB::transaction(function () use ($campaign) {
            // Attach pending leads to this campaign (MVP: all pending leads)
            $pending = CallLead::whereNull('campaign_id')
                ->where('status', 'pending');

            $total = (int) $pending->count();

            // Mark campaign running + stats
            $campaign->update([
                'status' => 'running',
                'started_at' => now(),
                'stopped_at' => null,
                'total_leads' => $total,
                'queued_leads' => 0,
                'completed_leads' => 0,
                'failed_leads' => 0,
            ]);

            // Assign campaign_id to leads
            $pending->update([
                'campaign_id' => $campaign->id,
                'status' => 'queued',
            ]);

            // Dispatch jobs (chunk to avoid memory issues)
            CallLead::where('campaign_id', $campaign->id)
                ->where('status', 'queued')
                ->orderBy('id')
                ->chunkById(200, function ($leads) use ($campaign) {
                    foreach ($leads as $lead) {
                        PlaceTwilioCallJob::dispatch($lead->id)->onQueue('calls');
                    }
                });

            // queued count = total (in MVP, we queued all)
            $campaign->update(['queued_leads' => $total]);
        });

        return back()->with('success', 'Campaign started and calls queued.');
    }

    public function stop(Campaign $campaign)
    {
        if ($campaign->user_id && $campaign->user_id !== Auth::id()) {
            abort(403);
        }

        if ($campaign->status !== 'running') {
            return back()->with('error', 'Campaign is not running.');
        }

        $campaign->update([
            'status' => 'stopped',
            'stopped_at' => now(),
        ]);

        // MVP: This stops new queuing (already queued jobs may still run).
        // Phase 2: implement job cancellation / stop flag check inside Job.

        return back()->with('success', 'Campaign stopped.');
    }
}