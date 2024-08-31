<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('component_doors', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Door::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Component::class)->constrained()->cascadeOnDelete();
            $table->primary(['component_id', 'door_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_doors');
    }
};
