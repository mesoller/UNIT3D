<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Treat;
use Illuminate\Database\Seeder;

class TreatSeeder extends Seeder
{
    public function run(): void
    {
        $level1 = [
            ['name' => 'Teh Tarik',  'description' => 'National favourite drinks.',      'icon' => '🍵', 'image' => 'teh-tarik.png', 'sort_order' => 10, 'cost' => 2500],
            ['name' => 'Eyeglass Candy', 'description' => 'Childhood memory candy.',      'icon' => '🍬', 'image' => 'eyeglass-candy.png', 'sort_order' => 20, 'cost' => 5000],
            ['name' => 'Lollipop',   'description' => 'A colourful swirled lollipop.',  'icon' => '🍭', 'sort_order' => 30, 'cost' => 5000],
            ['name' => 'Aiskrim Malaysia', 'description' => 'Low cost and easy to produce ice cream.', 'icon' => '🍦', 'image' => 'aiskrim-malaysia.png', 'sort_order' => 40, 'cost' => 5000],
            ['name' => 'Donut',      'description' => 'A glazed ring doughnut.',         'icon' => '🍩', 'sort_order' => 50, 'cost' => 10000],
            ['name' => 'Kuih Lapis', 'description' => 'Colourful, multi-layered steamed dessert.', 'icon' => '🍰', 'image' => 'kuih-lapis.png', 'sort_order' => 60, 'cost' => 10000],
        ];

        foreach ($level1 as $data) {
            Treat::updateOrCreate(
                ['name' => $data['name'], 'level' => 1],
                array_merge(['level' => 1, 'cost' => 500, 'is_active' => true], $data)
            );
        }

        $level2 = [
            ['name' => 'Apam Balik',    'description' => 'Sweet dessert at roadside stalls.', 'icon' => '🥞', 'image' => 'apam-balik.png', 'sort_order' => 10, 'cost' => 20000],
            ['name' => 'Tart Nenas',    'description' => 'Small, bite-size tart filled or topped with pineapple jam.', 'icon' => '🍮', 'image' => 'tart-nenas.png', 'sort_order' => 20, 'cost' => 20000],
            ['name' => 'Karipap',       'description' => 'A small turnover containing a filling of curry.', 'icon' => '🥟', 'image' => 'karipap.png', 'sort_order' => 30, 'cost' => 20000],
            ['name' => 'Tepung Pelita', 'description' => 'Made from coconut milk and rice flour and cooked in a container made from banana leaves.', 'icon' => '🍃', 'image' => 'tepung-pelita.png', 'sort_order' => 40, 'cost' => 20000],
            ['name' => 'Cendol',        'description' => 'Soft, green, worm-like jelly strands made from rice flour, coconut milk and palm sugar syrup, typically served over shaved ice.', 'icon' => '🍵', 'image' => 'cendol.png', 'sort_order' => 50, 'cost' => 20000],
            ['name' => 'Ketupat',       'description' => 'Compressed rice cake, famously serve during Hari Raya celebration.', 'icon' => '🍙', 'image' => 'ketupat.png', 'sort_order' => 60, 'cost' => 30000],
        ];

        foreach ($level2 as $data) {
            Treat::updateOrCreate(
                ['name' => $data['name'], 'level' => 2],
                array_merge($data, ['level' => 2, 'cost' => 2000, 'is_active' => true])
            );
        }

        $level3 = [
            ['name' => 'Nasi Lemak',        'description' => 'Malaysia national dish, rice cooked in coconut milk and pandan leaf.', 'icon' => '🍚', 'image' => 'nasi-lemak.png', 'sort_order' => 10, 'cost' => 50000],
            ['name' => 'Roti Canai',        'description' => 'An unleavened flatbread favourite breakfast dish.', 'icon' => '🫓', 'image' => 'roti-canai.png', 'sort_order' => 20, 'cost' => 50000],
            ['name' => 'Sate',              'description' => 'Small pieces of seasoned meat, seafood or vegetables skewered on sticks and grilled over charcoal.', 'icon' => '🍢', 'image' => 'sate.png', 'sort_order' => 30, 'cost' => 50000],
            ['name' => 'Durian',            'description' => 'The King of Fruit.',                     'icon' => '🍈', 'image' => 'durian.png', 'sort_order' => 40, 'cost' => 100000],
        ];

        foreach ($level3 as $data) {
            Treat::updateOrCreate(
                ['name' => $data['name'], 'level' => 3],
                array_merge(['level' => 3, 'cost' => 50000, 'is_active' => true], $data)
            );
        }
    }
}
