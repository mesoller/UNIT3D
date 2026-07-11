<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('shop_badges', function (Blueprint $table): void {
            $table->decimal('buy_price', 10, 2)->change();
            $table->decimal('sell_price', 10, 2)->change();
        });

        Schema::table('user_shop_badges', function (Blueprint $table): void {
            $table->decimal('purchase_price', 10, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('shop_badges', function (Blueprint $table): void {
            $table->unsignedInteger('buy_price')->change();
            $table->unsignedInteger('sell_price')->change();
        });

        Schema::table('user_shop_badges', function (Blueprint $table): void {
            $table->unsignedInteger('purchase_price')->change();
        });
    }
};
