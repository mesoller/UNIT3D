<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Treat;
use App\Models\User;
use App\Models\UserTreat;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TreatController extends Controller
{
    public function store(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()->is($user), 403);

        return DB::transaction(function () use ($request, $user): RedirectResponse {
            $user->refresh();
            $treat = Treat::findOrFail($request->integer('treat_id'));

            if (! $treat->is_active) {
                return back()->withErrors('This treat is no longer available.');
            }

            if (UserTreat::where('user_id', $user->id)->where('treat_id', $treat->id)->exists()) {
                return back()->withErrors('You already own this treat.');
            }

            if ($treat->cost > $user->seedbonus) {
                return back()->withErrors('Not enough BON.');
            }

            UserTreat::create([
                'user_id'      => $user->id,
                'treat_id'     => $treat->id,
                'purchased_at' => now(),
            ]);

            $user->decrement('seedbonus', $treat->cost);

            return back()->with('success', 'Treat purchased!');
        });
    }
}
