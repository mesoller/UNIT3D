<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Badge;
use App\Models\UserBadge;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutoAwardBadges extends Command
{
    protected $signature = 'auto:award-badges';

    protected $description = 'Award badges to users who meet the criteria';

    public function handle(): void
    {
        $badges = Badge::all();
        $now    = now();
        $awarded = 0;

        foreach ($badges as $badge) {
            $eligibleUserIds = match ($badge->criteria_type) {
                'anniversary'     => $this->eligibleForAnniversary((int) $badge->criteria_value),
                'total_uploads'   => $this->eligibleForUploads((int) $badge->criteria_value),
                'active_seedings' => $this->eligibleForSeedings((int) $badge->criteria_value),
                'ratio'           => $this->eligibleForRatio((float) $badge->criteria_value),
                'total_comments'  => $this->eligibleForComments((int) $badge->criteria_value),
                'bon_pool'        => $this->eligibleForBonPool((int) $badge->criteria_value),
                default           => collect(),
            };

            $alreadyHave = UserBadge::where('badge_id', $badge->id)
                ->pluck('user_id')
                ->flip();

            $toAward = $eligibleUserIds->reject(fn ($id) => $alreadyHave->has($id));

            foreach ($toAward as $userId) {
                UserBadge::firstOrCreate(
                    ['user_id' => $userId, 'badge_id' => $badge->id],
                    ['awarded_at' => $now],
                );
                $awarded++;
            }
        }

        $this->info("Awarded {$awarded} badge(s).");
    }

    private function eligibleForAnniversary(int $years): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->whereRaw('created_at <= DATE_SUB(NOW(), INTERVAL ? YEAR)', [$years])
            ->whereNull('deleted_at')
            ->pluck('id');
    }

    private function eligibleForUploads(int $minCount): \Illuminate\Support\Collection
    {
        return DB::table('torrents')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= ?', [$minCount])
            ->pluck('user_id');
    }

    private function eligibleForSeedings(int $minCount): \Illuminate\Support\Collection
    {
        return DB::table('peers')
            ->select('user_id')
            ->where('seeder', true)
            ->where('active', true)
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= ?', [$minCount])
            ->pluck('user_id');
    }

    private function eligibleForRatio(float $minRatio): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->whereRaw('downloaded > 0 AND (uploaded / downloaded) >= ?', [$minRatio])
            ->whereNull('deleted_at')
            ->pluck('id');
    }

    private function eligibleForComments(int $minCount): \Illuminate\Support\Collection
    {
        return DB::table('comments')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= ?', [$minCount])
            ->pluck('user_id');
    }

    private function eligibleForBonPool(int $minCount): \Illuminate\Support\Collection
    {
        return DB::table('bon_pool_contributions')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) >= ?', [$minCount])
            ->pluck('user_id');
    }
}
