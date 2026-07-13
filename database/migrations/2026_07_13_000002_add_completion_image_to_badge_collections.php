<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('badge_collections', function (Blueprint $table): void {
            $table->string('completion_image', 100)->nullable()->after('subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('badge_collections', function (Blueprint $table): void {
            $table->dropColumn('completion_image');
        });
    }
};
