<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bon_pool', function (Blueprint $table): void {
            $table->id();
            $table->timestamp('cycle_started_at');
            $table->timestamp('freeleech_until')->nullable();
            $table->timestamps();
        });

        // Seed singleton row
        \DB::table('bon_pool')->insert([
            'id'               => 1,
            'cycle_started_at' => now(),
            'freeleech_until'  => null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        Schema::create('bon_pool_contributions', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->decimal('amount', 20, 2)->unsigned();
            $table->boolean('anonymous')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bon_pool_contributions');
        Schema::dropIfExists('bon_pool');
    }
};
