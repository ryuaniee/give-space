<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class UserCampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with('category')
            ->where('status', 'active')
            ->latest()
            ->paginate(9);

        return view('user.campaigns.index', compact('campaigns'));
    }

    public function show(Campaign $campaign)
    {
        if ($campaign->status !== 'active') {
            abort(404);
        }

        $campaign->load('category');

        $collectedAmount = $campaign->transactions()
            ->where('status', 'verified')
            ->sum('amount');

        $progress = $campaign->target_amount > 0
            ? min(($collectedAmount / $campaign->target_amount) * 100, 100)
            : 0;

        return view('user.campaigns.show', compact(
            'campaign',
            'collectedAmount',
            'progress'
        ));
    }
}