<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\BadgeCollection;
use App\Models\UserShopBadge;

class BadgeController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $user = auth()->user();

        $earnedIds = $user->badges()->withPivot('awarded_at')->get()->keyBy('id');

        $badgesByCategory = Badge::orderBy('sort_order')->get()->groupBy('category');

        $collections = BadgeCollection::with(['shopBadges' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        $ownedShopIds = UserShopBadge::where('user_id', $user->id)->pluck('shop_badge_id')->flip();

        return view('badge.index', [
            'badgesByCategory' => $badgesByCategory,
            'earnedIds'        => $earnedIds,
            'collections'      => $collections,
            'ownedShopIds'     => $ownedShopIds,
        ]);
    }
}
