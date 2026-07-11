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
                'name'        => 'Boomer Collection',
                'description' => 'Koleksi lencana edisi terhad bertema klasik dan nostalgia.',
                'sort_order'  => 10,
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
                'name'        => 'Alien Collection',
                'description' => 'Koleksi lencana edisi terhad bertema alien dan luar angkasa.',
                'sort_order'  => 30,
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
                'name'        => 'Postman Collection',
                'description' => 'Koleksi lencana bertema pos dan penghantaran klasik.',
                'sort_order'  => 20,
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

        $anonymous = BadgeCollection::updateOrCreate(
            ['slug' => 'anonymous-collection'],
            [
                'name'        => 'Anonymous Collection',
                'description' => 'Koleksi lencana edisi terhad bertema identiti rahsia dan misteri.',
                'sort_order'  => 40,
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
                'name'        => 'Astronaut Collection',
                'description' => 'Koleksi lencana edisi terhad bertema angkasawan dan penerokaan luar angkasa.',
                'sort_order'  => 50,
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
                'name'        => 'Bartender Collection',
                'description' => 'Koleksi lencana edisi terhad bertema minuman dan kehidupan malam.',
                'sort_order'  => 60,
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
                'name'        => 'Beach Bum Collection',
                'description' => 'Koleksi lencana edisi terhad bertema pantai dan percutian tepi laut.',
                'sort_order'  => 70,
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
                'name'        => 'Beat Cop Collection',
                'description' => 'Koleksi lencana edisi terhad bertema polis dan penguatkuasaan undang-undang.',
                'sort_order'  => 80,
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
    }
}
