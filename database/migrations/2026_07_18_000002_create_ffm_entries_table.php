<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('ffm_entries', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('tmdb_movie_id');
            $table->unsignedSmallInteger('position');
            $table->unsignedSmallInteger('award_year')->nullable();
            $table->timestamps();
            $table->unique('tmdb_movie_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ffm_entries');
    }
};
