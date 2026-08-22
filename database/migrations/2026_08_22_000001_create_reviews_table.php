<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tmdb_movie_id')->nullable();
            $table->unsignedInteger('tmdb_tv_id')->nullable();
            $table->unsignedInteger('igdb_id')->nullable();
            $table->string('title');
            $table->text('body')->nullable();
            $table->unsignedTinyInteger('rating'); // 1-10
            $table->boolean('is_anonymous')->default(false);
            $table->boolean('is_spoiler')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tmdb_movie_id')->references('id')->on('tmdb_movies')->onDelete('cascade');
            $table->foreign('tmdb_tv_id')->references('id')->on('tmdb_tv')->onDelete('cascade');
            $table->foreign('igdb_id')->references('id')->on('igdb_games')->onDelete('cascade');
        });

        Schema::create('review_thanks', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('review_id');
            $table->timestamps();

            $table->unique(['user_id', 'review_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_thanks');
        Schema::dropIfExists('reviews');
    }
};
