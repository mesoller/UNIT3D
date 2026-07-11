<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BonPool;
use App\Models\BonPoolContribution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BonPoolController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View
    {
        $pool        = BonPool::instance();
        $target      = (float) config('bon_pool.target');
        $rewardDays  = (int) config('bon_pool.reward_days');
        $cycleTotal  = $pool->cycleTotal();
        $percent     = $target > 0 ? min(100, round(($cycleTotal / $target) * 100, 1)) : 0;

        $recent = BonPoolContribution::with('user')
            ->where('created_at', '>=', $pool->cycle_started_at)
            ->latest()
            ->limit(30)
            ->get();

        $topContributors = BonPoolContribution::select('user_id', DB::raw('SUM(amount) as total'))
            ->where('created_at', '>=', $pool->cycle_started_at)
            ->where('anonymous', false)
            ->whereNotNull('user_id')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->limit(25)
            ->with('user')
            ->get();

        return view('bon.pool', compact(
            'pool',
            'target',
            'rewardDays',
            'cycleTotal',
            'percent',
            'recent',
            'topContributors',
        ));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'amount'    => ['required', 'numeric', 'min:1'],
            'anonymous' => ['sometimes', 'boolean'],
        ]);

        $user   = $request->user();
        $amount = (float) $request->input('amount');

        if ($user->seedbonus < $amount) {
            return back()->withErrors(['amount' => 'You do not have enough BON to contribute that amount.']);
        }

        DB::transaction(function () use ($user, $amount, $request): void {
            $user->decrement('seedbonus', $amount);

            BonPoolContribution::create([
                'user_id'   => $user->id,
                'amount'    => $amount,
                'anonymous' => (bool) $request->boolean('anonymous'),
            ]);

            $pool    = BonPool::instance();
            $target  = (float) config('bon_pool.target');

            if ($pool->cycleTotal() >= $target) {
                $rewardDays = (int) config('bon_pool.reward_days');

                $pool->update([
                    'freeleech_until'  => now()->addDays($rewardDays),
                    'cycle_started_at' => now(),
                ]);

                cache()->forget('bon_pool_freeleech_active');
            }
        });

        return back()->with('success', 'Your BON contribution has been added to the pool!');
    }
}
