<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            // Anniversary
            [
                'slug'           => 'anniversary-1yr',
                'name'           => '1 Tahun Bersama',
                'description'    => 'Ahli MalayaBits selama 1 tahun. Terima kasih atas sokongan anda!',
                'category'       => 'anniversary',
                'icon'           => 'fa-calendar-check',
                'color'          => '#3b82f6',
                'criteria_type'  => 'anniversary',
                'criteria_value' => 1,
                'sort_order'     => 10,
            ],
            [
                'slug'           => 'anniversary-2yr',
                'name'           => '2 Tahun Bersama',
                'description'    => 'Ahli MalayaBits selama 2 tahun. Setia bersama kami!',
                'category'       => 'anniversary',
                'icon'           => 'fa-calendar-check',
                'color'          => '#22c55e',
                'criteria_type'  => 'anniversary',
                'criteria_value' => 2,
                'sort_order'     => 20,
            ],
            [
                'slug'           => 'anniversary-3yr',
                'name'           => '3 Tahun Bersama',
                'description'    => 'Ahli MalayaBits selama 3 tahun. Tiga tahun penuh kenangan!',
                'category'       => 'anniversary',
                'icon'           => 'fa-calendar-check',
                'color'          => '#f59e0b',
                'criteria_type'  => 'anniversary',
                'criteria_value' => 3,
                'sort_order'     => 30,
            ],
            [
                'slug'           => 'anniversary-4yr',
                'name'           => '4 Tahun Bersama',
                'description'    => 'Ahli MalayaBits selama 4 tahun. Kesetiaan anda kami hargai!',
                'category'       => 'anniversary',
                'icon'           => 'fa-calendar-check',
                'color'          => '#f97316',
                'criteria_type'  => 'anniversary',
                'criteria_value' => 4,
                'sort_order'     => 40,
            ],
            [
                'slug'           => 'anniversary-5yr',
                'name'           => '5 Tahun Bersama',
                'description'    => 'Ahli MalayaBits selama 5 tahun. Anda adalah tiang komuniti kami!',
                'category'       => 'anniversary',
                'icon'           => 'fa-crown',
                'color'          => '#a855f7',
                'criteria_type'  => 'anniversary',
                'criteria_value' => 5,
                'sort_order'     => 50,
            ],

            // Special
            [
                'slug'           => 'bon-pool-donor',
                'name'           => 'Penyumbang Kolam BON',
                'description'    => 'Telah menyumbang ke Kolam BON untuk membuka kunci freeleech global. Mulia!',
                'category'       => 'special',
                'icon'           => 'fa-coins',
                'color'          => '#d97706',
                'criteria_type'  => 'bon_pool',
                'criteria_value' => 1,
                'sort_order'     => 510,
            ],
            [
                'slug'           => 'myself-yourself',
                'name'           => 'Myself; Yourself',
                'description'    => 'Just you and your one mutual friend.',
                'category'       => 'special',
                'icon'           => 'fa-user-group',
                'color'          => '#ec4899',
                'criteria_type'  => 'mutual_follow_exact',
                'criteria_value' => 1,
                'sort_order'     => 520,
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate(['slug' => $badge['slug']], $badge);
        }
    }
}
