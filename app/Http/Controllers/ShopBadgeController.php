<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BadgeCollection;
use App\Models\ShopBadge;
use App\Models\UserCompletedCollection;
use App\Models\UserShopBadge;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopBadgeController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        $collections = BadgeCollection::with(['shopBadges' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        $ownedIds = UserShopBadge::where('user_id', $request->user()->id)
            ->pluck('shop_badge_id')
            ->flip();

        return view('badge.shop', compact('collections', 'ownedIds'));
    }

    public function buy(Request $request, ShopBadge $shopBadge): RedirectResponse
    {
        $user = $request->user();

        if (! $shopBadge->is_active) {
            return back()->withErrors('Lencana ini tidak tersedia untuk pembelian.');
        }

        if (UserShopBadge::where('user_id', $user->id)->where('shop_badge_id', $shopBadge->id)->exists()) {
            return back()->withErrors('Anda sudah memiliki lencana ini.');
        }

        if (! $shopBadge->isAvailable()) {
            return back()->withErrors('Lencana ini telah habis terjual. Cuba lagi kemudian.');
        }

        if ((float) $user->seedbonus < $shopBadge->buy_price) {
            return back()->withErrors('BON anda tidak mencukupi. Anda memerlukan '.number_format($shopBadge->buy_price, 2).' BON.');
        }

        DB::transaction(function () use ($user, $shopBadge): void {
            $user->decrement('seedbonus', $shopBadge->buy_price);

            UserShopBadge::create([
                'user_id'        => $user->id,
                'shop_badge_id'  => $shopBadge->id,
                'purchase_price' => $shopBadge->buy_price,
                'purchased_at'   => now(),
            ]);
        });

        // Check if user just completed the full collection
        $collection = $shopBadge->collection;
        $activeIds  = $collection->shopBadges()->where('is_active', true)->pluck('id');
        $ownedCount = UserShopBadge::where('user_id', $user->id)->whereIn('shop_badge_id', $activeIds)->count();

        if ($ownedCount === $activeIds->count() && $activeIds->count() > 0) {
            UserCompletedCollection::firstOrCreate(
                ['user_id' => $user->id, 'badge_collection_id' => $collection->id],
                ['completed_at' => now()]
            );
        }

        return back()->with('success', 'Tahniah! Anda telah berjaya membeli lencana "'.$shopBadge->name.'" dengan '.number_format($shopBadge->buy_price, 2).' BON.');
    }

    public function sell(Request $request, ShopBadge $shopBadge): RedirectResponse
    {
        $user = $request->user();

        $ownership = UserShopBadge::where('user_id', $user->id)
            ->where('shop_badge_id', $shopBadge->id)
            ->first();

        if ($ownership === null) {
            return back()->withErrors('Anda tidak memiliki lencana ini.');
        }

        DB::transaction(function () use ($user, $shopBadge, $ownership): void {
            $ownership->delete();
            $user->increment('seedbonus', $shopBadge->sell_price);

            // Selling a badge breaks the completed set
            UserCompletedCollection::where('user_id', $user->id)
                ->where('badge_collection_id', $shopBadge->badge_collection_id)
                ->delete();
        });

        return back()->with('success', 'Lencana "'.$shopBadge->name.'" telah dijual. '.number_format($shopBadge->sell_price, 2).' BON telah dikreditkan ke akaun anda.');
    }
}
