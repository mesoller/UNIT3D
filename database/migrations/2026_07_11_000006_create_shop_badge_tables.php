<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('badge_collections', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('shop_badges', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('badge_collection_id')->constrained('badge_collections')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('icon');                   // FA icon class
            $table->string('color', 20);              // CSS hex accent color
            $table->unsignedInteger('supply');        // max concurrent owners
            $table->unsignedInteger('buy_price');     // BON cost to buy
            $table->unsignedInteger('sell_price');    // BON returned on sell
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('user_shop_badges', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreignId('shop_badge_id')->constrained('shop_badges')->cascadeOnDelete();
            $table->unsignedInteger('purchase_price');
            $table->timestamp('purchased_at');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unique(['user_id', 'shop_badge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_shop_badges');
        Schema::dropIfExists('shop_badges');
        Schema::dropIfExists('badge_collections');
    }
};
