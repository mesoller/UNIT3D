<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('treats', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->string('icon', 10);
            $table->unsignedTinyInteger('level');
            $table->unsignedInteger('cost');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_treats', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('treat_id')->constrained()->cascadeOnDelete();
            $table->timestamp('purchased_at');
            $table->timestamps();
            $table->unique(['user_id', 'treat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_treats');
        Schema::dropIfExists('treats');
    }
};
