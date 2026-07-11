<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('bon_giveaways', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('amount');
            $table->unsignedInteger('winning_number');
            $table->unsignedInteger('start_num');
            $table->unsignedInteger('end_num');
            $table->unsignedInteger('chatroom_id');
            $table->unsignedBigInteger('last_message_id')->default(0);
            $table->unsignedInteger('reminder_interval_seconds');
            $table->timestamp('next_reminder_at')->nullable();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamp('ended_at')->nullable();
            $table->unsignedInteger('winner_user_id')->nullable();
            $table->foreign('winner_user_id')->references('id')->on('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('bon_giveaway_entries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('giveaway_id')->constrained('bon_giveaways')->cascadeOnDelete();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedInteger('entry_number');
            $table->timestamps();
            $table->unique(['giveaway_id', 'user_id']);
            $table->unique(['giveaway_id', 'entry_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bon_giveaway_entries');
        Schema::dropIfExists('bon_giveaways');
    }
};
