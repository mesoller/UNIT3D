<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Badge;

class BadgeController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $earnedIds = auth()->user()
            ->badges()
            ->withPivot('awarded_at')
            ->get()
            ->keyBy('id');

        $badgesByCategory = Badge::orderBy('sort_order')
            ->get()
            ->groupBy('category');

        return view('badge.index', [
            'badgesByCategory' => $badgesByCategory,
            'earnedIds'        => $earnedIds,
        ]);
    }
}
