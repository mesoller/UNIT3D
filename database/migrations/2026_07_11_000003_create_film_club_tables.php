<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('film_club_months', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('tmdb_movie_id');
            $table->string('year_month', 7);   // "2026-07"
            $table->unsignedInteger('winning_user_id')->nullable();
            $table->foreign('winning_user_id')->references('id')->on('users')->nullOnDelete();
            $table->unsignedInteger('total_votes')->default(0);
            $table->unsignedBigInteger('forum_topic_id')->nullable();
            $table->timestamps();
            $table->unique('year_month');
        });

        Schema::create('film_club_suggestions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->unsignedInteger('tmdb_movie_id');
            $table->string('for_month', 7);    // "2026-08"
            $table->timestamps();
            $table->unique(['tmdb_movie_id', 'for_month']);
        });

        Schema::create('film_club_votes', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('suggestion_id')->constrained('film_club_suggestions')->cascadeOnDelete();
            $table->string('for_month', 7);
            $table->timestamps();
            $table->unique(['user_id', 'for_month']);  // one vote per user per month
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('film_club_votes');
        Schema::dropIfExists('film_club_suggestions');
        Schema::dropIfExists('film_club_months');
    }
};
