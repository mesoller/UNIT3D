<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\BadgeCollection;
use App\Models\ShopBadge;
use Illuminate\Database\Seeder;

class ShopBadgeSeeder extends Seeder
{
    public function run(): void
    {
        $boomer = BadgeCollection::updateOrCreate(
            ['slug' => 'boomer-collection'],
            [
                'name'             => 'Boomer Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema klasik dan nostalgia.',
                'completion_image' => 'boomer-collection.png',
                'sort_order'       => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'postage-stamp'],
            [
                'badge_collection_id' => $boomer->id,
                'name'                => 'Postage Stamp',
                'description'         => 'Lencana setem pos edisi terhad daripada Boomer Collection. Hanya 1,000 unit tersedia!',
                'icon'                => 'fa-stamp',
                'color'               => '#8b6914',
                'supply'              => 1000,
                'buy_price'           => 32000,
                'sell_price'          => 32000,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'slide-projector'],
            [
                'badge_collection_id' => $boomer->id,
                'name'                => 'Slide Projector',
                'description'         => 'Lencana projektor slaid vintaj daripada Boomer Collection. Hanya 2,500 unit tersedia!',
                'icon'                => 'fa-projector',
                'color'               => '#7c7c7c',
                'supply'              => 2500,
                'buy_price'           => 320000,
                'sell_price'          => 320000,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'checkbook'],
            [
                'badge_collection_id' => $boomer->id,
                'name'                => 'Checkbook',
                'description'         => 'Lencana buku cek vintaj daripada Boomer Collection. Hanya 2,500 unit tersedia!',
                'icon'                => 'fa-money-check-dollar',
                'color'               => '#6b7280',
                'supply'              => 2500,
                'buy_price'           => 160000,
                'sell_price'          => 160000,
                'is_active'           => true,
                'sort_order'          => 35,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'postcard'],
            [
                'badge_collection_id' => $boomer->id,
                'name'                => 'Postcard',
                'description'         => 'Lencana poskad vintaj daripada Boomer Collection. Hanya 4,000 unit tersedia!',
                'icon'                => 'fa-image',
                'color'               => '#7a9eb5',
                'supply'              => 4000,
                'buy_price'           => 64000,
                'sell_price'          => 64000,
                'is_active'           => true,
                'sort_order'          => 15,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'newspaper'],
            [
                'badge_collection_id' => $boomer->id,
                'name'                => 'Newspaper',
                'description'         => 'Lencana akhbar vintaj daripada Boomer Collection. Hanya 2,500 unit tersedia!',
                'icon'                => 'fa-newspaper',
                'color'               => '#5a5a5a',
                'supply'              => 2500,
                'buy_price'           => 32000,
                'sell_price'          => 32000,
                'is_active'           => true,
                'sort_order'          => 25,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'business-card'],
            [
                'badge_collection_id' => $boomer->id,
                'name'                => 'Business Card',
                'description'         => 'Lencana kad perniagaan eksklusif daripada Boomer Collection. Hanya 2,500 unit tersedia!',
                'icon'                => 'fa-address-card',
                'color'               => '#8a8a8a',
                'supply'              => 2500,
                'buy_price'           => 160000,
                'sell_price'          => 160000,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        $alien = BadgeCollection::updateOrCreate(
            ['slug' => 'alien-collection'],
            [
                'name'             => 'Alien Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema alien dan luar angkasa.',
                'completion_image' => 'alien-collection.png',
                'sort_order'       => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'ray-ban-sunglasses'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Ray-Ban Sunglasses',
                'description'         => 'Lencana cermin mata Ray-Ban eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-glasses',
                'color'               => '#374151',
                'supply'              => 25,
                'buy_price'           => 47500.00,
                'sell_price'          => 47500.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'flamethrower'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Flamethrower',
                'description'         => 'Lencana penyembur api eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-fire-flame-curved',
                'color'               => '#f97316',
                'supply'              => 25,
                'buy_price'           => 9999.99,
                'sell_price'          => 9999.99,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bicycle'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Bicycle',
                'description'         => 'Lencana basikal eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-bicycle',
                'color'               => '#6b7280',
                'supply'              => 25,
                'buy_price'           => 4204.20,
                'sell_price'          => 4204.20,
                'is_active'           => true,
                'sort_order'          => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'pack-of-marlboros'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Pack of Marlboros',
                'description'         => 'Lencana pek rokok eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-smoking',
                'color'               => '#9ca3af',
                'supply'              => 25,
                'buy_price'           => 2021,
                'sell_price'          => 2021,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'flashlight'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Flashlight',
                'description'         => 'Lencana suluh eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-flashlight',
                'color'               => '#f59e0b',
                'supply'              => 25,
                'buy_price'           => 5000,
                'sell_price'          => 5000,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'radio-telescope'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Radio Telescope',
                'description'         => 'Lencana teleskop radio eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-satellite-dish',
                'color'               => '#52b788',
                'supply'              => 25,
                'buy_price'           => 250000,
                'sell_price'          => 250000,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'hazmat-helmet'],
            [
                'badge_collection_id' => $alien->id,
                'name'                => 'Hazmat Helmet',
                'description'         => 'Lencana helmet hazmat eksklusif daripada Alien Collection. Hanya 25 unit tersedia!',
                'icon'                => 'fa-helmet-safety',
                'color'               => '#52b788',
                'supply'              => 25,
                'buy_price'           => 57500,
                'sell_price'          => 57500,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        $postman = BadgeCollection::updateOrCreate(
            ['slug' => 'postman-collection'],
            [
                'name'             => 'Postman Collection',
                'description'      => 'Koleksi lencana bertema pos dan penghantaran klasik.',
                'completion_image' => 'postman-collection.png',
                'sort_order'       => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'rocking-horse'],
            [
                'badge_collection_id' => $postman->id,
                'name'                => 'Rocking Horse',
                'description'         => 'Lencana kuda goyang klasik daripada Postman Collection. Bekalan tidak terhad!',
                'icon'                => 'fa-horse',
                'color'               => '#a0785a',
                'supply'              => 0,
                'buy_price'           => 250000,
                'sell_price'          => 250000,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'confetti'],
            [
                'badge_collection_id' => $postman->id,
                'name'                => 'Confetti',
                'description'         => 'Lencana Confetti eksklusif daripada Postman Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-wand-magic-sparkles',
                'color'               => '#f472b6',
                'supply'              => 10,
                'buy_price'           => 25000.00,
                'sell_price'          => 25000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'teddy-bear'],
            [
                'badge_collection_id' => $postman->id,
                'name'                => 'Teddy Bear',
                'description'         => 'Lencana Teddy Bear eksklusif daripada Postman Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-paw',
                'color'               => '#92400e',
                'supply'              => 10,
                'buy_price'           => 250000.00,
                'sell_price'          => 250000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'lumps-of-coal'],
            [
                'badge_collection_id' => $postman->id,
                'name'                => 'Lumps of Coal',
                'description'         => 'Lencana Lumps of Coal eksklusif daripada Postman Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-cubes-stacked',
                'color'               => '#374151',
                'supply'              => 10,
                'buy_price'           => 12500.00,
                'sell_price'          => 12500.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        $anonymous = BadgeCollection::updateOrCreate(
            ['slug' => 'anonymous-collection'],
            [
                'name'             => 'Anonymous Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema identiti rahsia dan misteri.',
                'completion_image' => 'anonymous-collection.png',
                'sort_order'       => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bar-of-soap'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Bar of Soap',
                'description'         => 'Lencana sabun bar eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-soap',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 10000.00,
                'sell_price'          => 10000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'polaroid-camera'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Polaroid Camera',
                'description'         => 'Lencana kamera polaroid eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-camera-retro',
                'color'               => '#64748b',
                'supply'              => 10,
                'buy_price'           => 75000.00,
                'sell_price'          => 75000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'guy-fawkes-mask'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Guy Fawkes Mask',
                'description'         => 'Lencana topeng Guy Fawkes eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-mask',
                'color'               => '#78716c',
                'supply'              => 10,
                'buy_price'           => 200000.00,
                'sell_price'          => 200000.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'taxi-sign'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Taxi Sign',
                'description'         => 'Lencana tanda teksi eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-taxi',
                'color'               => '#eab308',
                'supply'              => 10,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bowler-hat'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Bowler Hat',
                'description'         => 'Lencana topi bowler eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-hat-cowboy',
                'color'               => '#57534e',
                'supply'              => 10,
                'buy_price'           => 20000.00,
                'sell_price'          => 20000.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'molotov-cocktail'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Molotov Cocktail',
                'description'         => 'Lencana koktel molotov eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-wine-bottle',
                'color'               => '#dc2626',
                'supply'              => 10,
                'buy_price'           => 40000.00,
                'sell_price'          => 40000.00,
                'is_active'           => true,
                'sort_order'          => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'shooting-target'],
            [
                'badge_collection_id' => $anonymous->id,
                'name'                => 'Shooting Target',
                'description'         => 'Lencana sasaran tembak eksklusif daripada Anonymous Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-bullseye',
                'color'               => '#6b7280',
                'supply'              => 10,
                'buy_price'           => 5000.00,
                'sell_price'          => 5000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );
        $astronaut = BadgeCollection::updateOrCreate(
            ['slug' => 'astronaut-collection'],
            [
                'name'             => 'Astronaut Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema angkasawan dan penerokaan luar angkasa.',
                'completion_image' => 'astronaut-collection.png',
                'sort_order'       => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'space-suit'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'Space Suit',
                'description'         => 'Lencana suit angkasa eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-user-astronaut',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 125000.00,
                'sell_price'          => 125000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'space-helmet'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'Space Helmet',
                'description'         => 'Lencana helmet angkasa eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-helmet-safety',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 75000.00,
                'sell_price'          => 75000.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'eve'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'EVE',
                'description'         => 'Lencana EVE eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-robot',
                'color'               => '#e2e8f0',
                'supply'              => 10,
                'buy_price'           => 200000.00,
                'sell_price'          => 200000.00,
                'is_active'           => true,
                'sort_order'          => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'astromech-droid'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'Astromech Droid',
                'description'         => 'Lencana droid astromekanikal eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-robot',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 300000.00,
                'sell_price'          => 300000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'solar-panel'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'Solar Panel',
                'description'         => 'Lencana panel solar eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-solar-panel',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 145000.00,
                'sell_price'          => 145000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'lightsabers'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'Lightsabers',
                'description'         => 'Lencana lightsaber eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-swords',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 250000.00,
                'sell_price'          => 250000.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'launch-pod'],
            [
                'badge_collection_id' => $astronaut->id,
                'name'                => 'Launch Pod',
                'description'         => 'Lencana kapsul pelancaran eksklusif daripada Astronaut Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-shuttle-space',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 350000.00,
                'sell_price'          => 350000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );
        $bartender = BadgeCollection::updateOrCreate(
            ['slug' => 'bartender-collection'],
            [
                'name'             => 'Bartender Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema minuman dan kehidupan malam.',
                'completion_image' => 'bartender-collection.png',
                'sort_order'       => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'broken-bottle'],
            [
                'badge_collection_id' => $bartender->id,
                'name'                => 'Broken Bottle',
                'description'         => 'Lencana botol pecah eksklusif daripada Bartender Collection. Hanya 125 unit tersedia!',
                'icon'                => 'fa-wine-bottle',
                'color'               => '#b45309',
                'supply'              => 125,
                'buy_price'           => 125.00,
                'sell_price'          => 125.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'napkins'],
            [
                'badge_collection_id' => $bartender->id,
                'name'                => 'Napkins',
                'description'         => 'Lencana napkin eksklusif daripada Bartender Collection. Hanya 125 unit tersedia!',
                'icon'                => 'fa-scroll',
                'color'               => '#b45309',
                'supply'              => 125,
                'buy_price'           => 125.00,
                'sell_price'          => 125.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'ashtray'],
            [
                'badge_collection_id' => $bartender->id,
                'name'                => 'Ashtray',
                'description'         => 'Lencana asbak eksklusif daripada Bartender Collection. Hanya 125 unit tersedia!',
                'icon'                => 'fa-smoking',
                'color'               => '#b45309',
                'supply'              => 125,
                'buy_price'           => 25000.00,
                'sell_price'          => 25000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'beer-tap'],
            [
                'badge_collection_id' => $bartender->id,
                'name'                => 'Beer Tap',
                'description'         => 'Lencana pili bir eksklusif daripada Bartender Collection. Hanya 125 unit tersedia!',
                'icon'                => 'fa-beer-mug-empty',
                'color'               => '#b45309',
                'supply'              => 125,
                'buy_price'           => 350.00,
                'sell_price'          => 350.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bar-stool'],
            [
                'badge_collection_id' => $bartender->id,
                'name'                => 'Bar Stool',
                'description'         => 'Lencana kerusi bar eksklusif daripada Bartender Collection. Hanya 125 unit tersedia!',
                'icon'                => 'fa-chair',
                'color'               => '#b45309',
                'supply'              => 125,
                'buy_price'           => 50.00,
                'sell_price'          => 50.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'cocktail-shaker'],
            [
                'badge_collection_id' => $bartender->id,
                'name'                => 'Cocktail Shaker',
                'description'         => 'Lencana pengocok koktel eksklusif daripada Bartender Collection. Hanya 125 unit tersedia!',
                'icon'                => 'fa-martini-glass-citrus',
                'color'               => '#b45309',
                'supply'              => 125,
                'buy_price'           => 25000.00,
                'sell_price'          => 25000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );
        $beachBum = BadgeCollection::updateOrCreate(
            ['slug' => 'beach-bum-collection'],
            [
                'name'             => 'Beach Bum Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema pantai dan percutian tepi laut.',
                'completion_image' => 'beach-bum-collection.png',
                'sort_order'       => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'life-raft'],
            [
                'badge_collection_id' => $beachBum->id,
                'name'                => 'Life Raft',
                'description'         => 'Lencana rakit penyelamat eksklusif daripada Beach Bum Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-compact-disc',
                'color'               => '#0ea5e9',
                'supply'              => 10,
                'buy_price'           => 175000.00,
                'sell_price'          => 175000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'paddles'],
            [
                'badge_collection_id' => $beachBum->id,
                'name'                => 'Paddles',
                'description'         => 'Lencana dayung eksklusif daripada Beach Bum Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-table-tennis-paddle-ball',
                'color'               => '#0ea5e9',
                'supply'              => 10,
                'buy_price'           => 22500.00,
                'sell_price'          => 22500.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'ss-minnow-life-preserver'],
            [
                'badge_collection_id' => $beachBum->id,
                'name'                => 'S.S. Minnow Life Preserver',
                'description'         => 'Lencana pelampung penyelamat S.S. Minnow daripada Beach Bum Collection. Bekalan tidak terhad!',
                'icon'                => 'fa-life-ring',
                'color'               => '#0ea5e9',
                'supply'              => 0,
                'buy_price'           => 16500.00,
                'sell_price'          => 16500.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'lifesaver'],
            [
                'badge_collection_id' => $beachBum->id,
                'name'                => 'Lifesaver',
                'description'         => 'Lencana penyelamat eksklusif daripada Beach Bum Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-ring',
                'color'               => '#0ea5e9',
                'supply'              => 10,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'surfboard'],
            [
                'badge_collection_id' => $beachBum->id,
                'name'                => 'Surfboard',
                'description'         => 'Lencana papan luncur eksklusif daripada Beach Bum Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-person-surfing',
                'color'               => '#0ea5e9',
                'supply'              => 10,
                'buy_price'           => 100000.00,
                'sell_price'          => 100000.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'beach-chair'],
            [
                'badge_collection_id' => $beachBum->id,
                'name'                => 'Beach Chair',
                'description'         => 'Lencana kerusi pantai eksklusif daripada Beach Bum Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-umbrella-beach',
                'color'               => '#0ea5e9',
                'supply'              => 10,
                'buy_price'           => 5000.00,
                'sell_price'          => 5000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );
        $beatCop = BadgeCollection::updateOrCreate(
            ['slug' => 'beat-cop-collection'],
            [
                'name'             => 'Beat Cop Collection',
                'description'      => 'Koleksi lencana edisi terhad bertema polis dan penguatkuasaan undang-undang.',
                'completion_image' => 'beat-cop-collection.png',
                'sort_order'       => 80,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bandage'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Bandage',
                'description'         => 'Lencana pembalut luka eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-bandage',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 100.00,
                'sell_price'          => 100.00,
                'is_active'           => true,
                'sort_order'          => 90,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'police-siren'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Police Siren',
                'description'         => 'Lencana siren polis eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-siren',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 250.00,
                'sell_price'          => 250.00,
                'is_active'           => true,
                'sort_order'          => 100,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'evidence-bag'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Evidence Bag',
                'description'         => 'Lencana beg bukti eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-receipt',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 40000.00,
                'sell_price'          => 40000.00,
                'is_active'           => true,
                'sort_order'          => 110,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'chain-dog-collar'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Chain Dog Collar',
                'description'         => 'Lencana rantai kolar anjing eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-link',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 120,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'crime-board'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Crime Board',
                'description'         => 'Lencana papan jenayah eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-chalkboard',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 125.00,
                'sell_price'          => 125.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'handcuffs'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Handcuffs',
                'description'         => 'Lencana gari eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-handcuffs',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 250.00,
                'sell_price'          => 250.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'whistle'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Whistle',
                'description'         => 'Lencana wisel eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-whistle',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 250.00,
                'sell_price'          => 250.00,
                'is_active'           => true,
                'sort_order'          => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'breathalyzer'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Breathalyzer',
                'description'         => 'Lencana alat nafas eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-wind',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 250.00,
                'sell_price'          => 250.00,
                'is_active'           => true,
                'sort_order'          => 80,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'flashbang'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Flashbang',
                'description'         => 'Lencana bom kilat eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-bomb',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 175.00,
                'sell_price'          => 175.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'school-backpack'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'School Backpack',
                'description'         => 'Lencana beg sekolah eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-bag-shopping',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'pocket-knife'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Pocket Knife',
                'description'         => 'Lencana pisau poket eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-knife',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 50.00,
                'sell_price'          => 50.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'police-hat'],
            [
                'badge_collection_id' => $beatCop->id,
                'name'                => 'Police Hat',
                'description'         => 'Lencana topi polis eksklusif daripada Beat Cop Collection. Hanya 50 unit tersedia!',
                'icon'                => 'fa-hat-police',
                'color'               => '#1d4ed8',
                'supply'              => 50,
                'buy_price'           => 200.00,
                'sell_price'          => 200.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        // ── Celebrity Collection ─────────────────────────────────────────────
        $celebrity = BadgeCollection::updateOrCreate(
            ['slug' => 'celebrity-collection'],
            [
                'name'             => 'Celebrity Collection',
                'description'      => 'Koleksi eksklusif bertema selebriti.',
                'completion_image' => 'celebrity-collection.png',
                'sort_order'       => 90,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'dumplings'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Dumplings',
                'description'         => 'Lencana Dumplings eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-bowl-food',
                'color'               => '#f59e0b',
                'supply'              => 10,
                'buy_price'           => 75000.00,
                'sell_price'          => 75000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'fox'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Fox',
                'description'         => 'Lencana Fox eksklusif daripada Celebrity Collection. Bekalan tanpa had!',
                'icon'                => 'fa-fox',
                'color'               => '#f97316',
                'supply'              => 0,
                'buy_price'           => 250000.00,
                'sell_price'          => 250000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'monkey'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Monkey',
                'description'         => 'Lencana Monkey eksklusif daripada Celebrity Collection. Bekalan tanpa had!',
                'icon'                => 'fa-monkey',
                'color'               => '#78716c',
                'supply'              => 0,
                'buy_price'           => 250000.00,
                'sell_price'          => 250000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'dominoes'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Dominoes',
                'description'         => 'Lencana Dominoes eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-dice',
                'color'               => '#e5e7eb',
                'supply'              => 10,
                'buy_price'           => 225000.00,
                'sell_price'          => 225000.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'hockey-skate'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Hockey Skate',
                'description'         => 'Lencana Hockey Skate eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-skating',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 225000.00,
                'sell_price'          => 225000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'case-of-plutonium'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Case of Plutonium',
                'description'         => 'Lencana Case of Plutonium eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-radiation',
                'color'               => '#84cc16',
                'supply'              => 10,
                'buy_price'           => 550000.00,
                'sell_price'          => 550000.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'garden-gnome'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Garden Gnome',
                'description'         => 'Lencana Garden Gnome eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-hat-wizard',
                'color'               => '#ef4444',
                'supply'              => 10,
                'buy_price'           => 550000.00,
                'sell_price'          => 550000.00,
                'is_active'           => true,
                'sort_order'          => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'dinosaur-skeleton'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Dinosaur Skeleton',
                'description'         => 'Lencana Dinosaur Skeleton eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-skull',
                'color'               => '#d4d4d4',
                'supply'              => 10,
                'buy_price'           => 550000.00,
                'sell_price'          => 550000.00,
                'is_active'           => true,
                'sort_order'          => 80,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'diamonds'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Diamonds',
                'description'         => 'Lencana Diamonds eksklusif daripada Celebrity Collection. Bekalan tanpa had!',
                'icon'                => 'fa-gem',
                'color'               => '#a5f3fc',
                'supply'              => 0,
                'buy_price'           => 499000.00,
                'sell_price'          => 499000.00,
                'is_active'           => true,
                'sort_order'          => 90,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'las-vegas-sign'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Las Vegas Sign',
                'description'         => 'Lencana Las Vegas Sign eksklusif daripada Celebrity Collection. Bekalan tanpa had!',
                'icon'                => 'fa-signs-post',
                'color'               => '#fbbf24',
                'supply'              => 0,
                'buy_price'           => 99000.00,
                'sell_price'          => 99000.00,
                'is_active'           => true,
                'sort_order'          => 100,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'blackboard'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Blackboard',
                'description'         => 'Lencana Blackboard eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-chalkboard',
                'color'               => '#6b7280',
                'supply'              => 10,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 110,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'nunchaku'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Nunchaku',
                'description'         => 'Lencana Nunchaku eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-link',
                'color'               => '#d1d5db',
                'supply'              => 10,
                'buy_price'           => 125000.00,
                'sell_price'          => 125000.00,
                'is_active'           => true,
                'sort_order'          => 120,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bag-of-sand'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Bag of Sand',
                'description'         => 'Lencana Bag of Sand eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-bag-shopping',
                'color'               => '#d4a96a',
                'supply'              => 10,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 130,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'power-drill'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Power Drill',
                'description'         => 'Lencana Power Drill eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-screwdriver',
                'color'               => '#f97316',
                'supply'              => 10,
                'buy_price'           => 225000.00,
                'sell_price'          => 225000.00,
                'is_active'           => true,
                'sort_order'          => 140,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'chopsticks'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Chopsticks',
                'description'         => 'Lencana Chopsticks eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-utensils',
                'color'               => '#a8a29e',
                'supply'              => 10,
                'buy_price'           => 50000.00,
                'sell_price'          => 50000.00,
                'is_active'           => true,
                'sort_order'          => 150,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'shopping-cart'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Shopping Cart',
                'description'         => 'Lencana Shopping Cart eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-cart-shopping',
                'color'               => '#94a3b8',
                'supply'              => 10,
                'buy_price'           => 125000.00,
                'sell_price'          => 125000.00,
                'is_active'           => true,
                'sort_order'          => 160,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'fish-bones'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Fish Bones',
                'description'         => 'Lencana Fish Bones eksklusif daripada Celebrity Collection. Hanya 10 unit tersedia!',
                'icon'                => 'fa-fish',
                'color'               => '#9ca3af',
                'supply'              => 10,
                'buy_price'           => 125000.00,
                'sell_price'          => 125000.00,
                'is_active'           => true,
                'sort_order'          => 170,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'penguin'],
            [
                'badge_collection_id' => $celebrity->id,
                'name'                => 'Penguin',
                'description'         => 'Lencana Penguin eksklusif daripada Celebrity Collection. Bekalan tanpa had!',
                'icon'                => 'fa-crow',
                'color'               => '#475569',
                'supply'              => 0,
                'buy_price'           => 250000.00,
                'sell_price'          => 250000.00,
                'is_active'           => true,
                'sort_order'          => 180,
            ]
        );

        // ── Chef Collection ──────────────────────────────────────────────────
        $chef = BadgeCollection::updateOrCreate(
            ['slug' => 'chef-collection'],
            [
                'name'             => 'Chef Collection',
                'description'      => 'Koleksi eksklusif bertema chef dan masakan.',
                'completion_image' => 'chef-collection.png',
                'sort_order'       => 100,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'pizza'],
            [
                'badge_collection_id' => $chef->id,
                'name'                => 'Pizza',
                'description'         => 'Lencana Pizza eksklusif daripada Chef Collection. Hanya 20 unit tersedia!',
                'icon'                => 'fa-pizza-slice',
                'color'               => '#f97316',
                'supply'              => 20,
                'buy_price'           => 70000.00,
                'sell_price'          => 70000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'piece-of-cheese'],
            [
                'badge_collection_id' => $chef->id,
                'name'                => 'Piece of Cheese',
                'description'         => 'Lencana Piece of Cheese eksklusif daripada Chef Collection. Hanya 20 unit tersedia!',
                'icon'                => 'fa-cheese',
                'color'               => '#fbbf24',
                'supply'              => 20,
                'buy_price'           => 42500.00,
                'sell_price'          => 42500.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'supersized-fries'],
            [
                'badge_collection_id' => $chef->id,
                'name'                => 'Supersized Fries',
                'description'         => 'Lencana Supersized Fries eksklusif daripada Chef Collection. Hanya 20 unit tersedia!',
                'icon'                => 'fa-burger',
                'color'               => '#f59e0b',
                'supply'              => 20,
                'buy_price'           => 7500.00,
                'sell_price'          => 7500.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'donut'],
            [
                'badge_collection_id' => $chef->id,
                'name'                => 'Donut',
                'description'         => 'Lencana Donut eksklusif daripada Chef Collection. Hanya 20 unit tersedia!',
                'icon'                => 'fa-ring',
                'color'               => '#f9a8d4',
                'supply'              => 20,
                'buy_price'           => 18500.00,
                'sell_price'          => 18500.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'slider'],
            [
                'badge_collection_id' => $chef->id,
                'name'                => 'Slider',
                'description'         => 'Lencana Slider eksklusif daripada Chef Collection. Hanya 20 unit tersedia!',
                'icon'                => 'fa-burger',
                'color'               => '#d97706',
                'supply'              => 20,
                'buy_price'           => 14000.00,
                'sell_price'          => 14000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'sushi'],
            [
                'badge_collection_id' => $chef->id,
                'name'                => 'Sushi',
                'description'         => 'Lencana Sushi eksklusif daripada Chef Collection. Hanya 20 unit tersedia!',
                'icon'                => 'fa-fish-fins',
                'color'               => '#94a3b8',
                'supply'              => 20,
                'buy_price'           => 60000.00,
                'sell_price'          => 60000.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        // ── Coach Collection ─────────────────────────────────────────────────
        $coach = BadgeCollection::updateOrCreate(
            ['slug' => 'coach-collection'],
            [
                'name'             => 'Coach Collection',
                'description'      => 'Koleksi eksklusif bertema jurulatih sukan.',
                'completion_image' => 'coach-collection.png',
                'sort_order'       => 110,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'tennis-ball'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Tennis Ball',
                'description'         => 'Lencana Tennis Ball eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-baseball',
                'color'               => '#84cc16',
                'supply'              => 30,
                'buy_price'           => 120000.00,
                'sell_price'          => 120000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'baseball-glove'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Baseball Glove',
                'description'         => 'Lencana Baseball Glove eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-hand-back-fist',
                'color'               => '#b45309',
                'supply'              => 30,
                'buy_price'           => 60000.00,
                'sell_price'          => 60000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'bicycle-wheel'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Bicycle Wheel',
                'description'         => 'Lencana Bicycle Wheel eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-circle-dot',
                'color'               => '#6b7280',
                'supply'              => 30,
                'buy_price'           => 90000.00,
                'sell_price'          => 90000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'curling-rock'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Curling Rock',
                'description'         => 'Lencana Curling Rock eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-circle',
                'color'               => '#94a3b8',
                'supply'              => 30,
                'buy_price'           => 150000.00,
                'sell_price'          => 150000.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'football-helmet'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Football Helmet',
                'description'         => 'Lencana Football Helmet eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-helmet-safety',
                'color'               => '#6b7280',
                'supply'              => 30,
                'buy_price'           => 120000.00,
                'sell_price'          => 120000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'figure-skate'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Figure Skate',
                'description'         => 'Lencana Figure Skate eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-skating',
                'color'               => '#93c5fd',
                'supply'              => 30,
                'buy_price'           => 90000.00,
                'sell_price'          => 90000.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'basketball-jersey'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Basketball Jersey',
                'description'         => 'Lencana Basketball Jersey eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-shirt',
                'color'               => '#f97316',
                'supply'              => 30,
                'buy_price'           => 30000.00,
                'sell_price'          => 30000.00,
                'is_active'           => true,
                'sort_order'          => 70,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'goalposts'],
            [
                'badge_collection_id' => $coach->id,
                'name'                => 'Goalposts',
                'description'         => 'Lencana Goalposts eksklusif daripada Coach Collection. Hanya 30 unit tersedia!',
                'icon'                => 'fa-goal-net',
                'color'               => '#d1d5db',
                'supply'              => 30,
                'buy_price'           => 60000.00,
                'sell_price'          => 60000.00,
                'is_active'           => true,
                'sort_order'          => 80,
            ]
        );

        // ── Crime Boss Collection ────────────────────────────────────────────
        $crimeBoss = BadgeCollection::updateOrCreate(
            ['slug' => 'crime-boss-collection'],
            [
                'name'             => 'Crime Boss Collection',
                'description'      => 'Koleksi eksklusif bertema bos jenayah dan dunia bawah tanah.',
                'completion_image' => 'crime-boss-collection.png',
                'sort_order'       => 120,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'money-bag'],
            [
                'badge_collection_id' => $crimeBoss->id,
                'name'                => 'Money Bag',
                'description'         => 'Lencana Money Bag eksklusif daripada Crime Boss Collection. Hanya 15 unit tersedia!',
                'icon'                => 'fa-sack-dollar',
                'color'               => '#ca8a04',
                'supply'              => 15,
                'buy_price'           => 5000.00,
                'sell_price'          => 5000.00,
                'is_active'           => true,
                'sort_order'          => 10,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'brass-knuckles'],
            [
                'badge_collection_id' => $crimeBoss->id,
                'name'                => 'Brass Knuckles',
                'description'         => 'Lencana Brass Knuckles eksklusif daripada Crime Boss Collection. Hanya 15 unit tersedia!',
                'icon'                => 'fa-hand-fist',
                'color'               => '#b45309',
                'supply'              => 15,
                'buy_price'           => 35000.00,
                'sell_price'          => 35000.00,
                'is_active'           => true,
                'sort_order'          => 20,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'ace-of-spades'],
            [
                'badge_collection_id' => $crimeBoss->id,
                'name'                => 'Ace of Spades',
                'description'         => 'Lencana Ace of Spades eksklusif daripada Crime Boss Collection. Hanya 15 unit tersedia!',
                'icon'                => 'fa-playing-cards',
                'color'               => '#e5e7eb',
                'supply'              => 15,
                'buy_price'           => 35000.00,
                'sell_price'          => 35000.00,
                'is_active'           => true,
                'sort_order'          => 30,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'cigar'],
            [
                'badge_collection_id' => $crimeBoss->id,
                'name'                => 'Cigar',
                'description'         => 'Lencana Cigar eksklusif daripada Crime Boss Collection. Hanya 15 unit tersedia!',
                'icon'                => 'fa-smoking',
                'color'               => '#78716c',
                'supply'              => 15,
                'buy_price'           => 5000.00,
                'sell_price'          => 5000.00,
                'is_active'           => true,
                'sort_order'          => 40,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'dice'],
            [
                'badge_collection_id' => $crimeBoss->id,
                'name'                => 'Dice',
                'description'         => 'Lencana Dice eksklusif daripada Crime Boss Collection. Hanya 15 unit tersedia!',
                'icon'                => 'fa-dice',
                'color'               => '#e5e7eb',
                'supply'              => 15,
                'buy_price'           => 4000.00,
                'sell_price'          => 4000.00,
                'is_active'           => true,
                'sort_order'          => 50,
            ]
        );

        ShopBadge::updateOrCreate(
            ['slug' => 'spinning-top'],
            [
                'badge_collection_id' => $crimeBoss->id,
                'name'                => 'Spinning Top',
                'description'         => 'Lencana Spinning Top eksklusif daripada Crime Boss Collection. Hanya 15 unit tersedia!',
                'icon'                => 'fa-spinner',
                'color'               => '#94a3b8',
                'supply'              => 15,
                'buy_price'           => 2500.00,
                'sell_price'          => 2500.00,
                'is_active'           => true,
                'sort_order'          => 60,
            ]
        );
    }
}
