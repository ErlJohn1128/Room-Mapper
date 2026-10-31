<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Building;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code');

            $table->foreignIdFor(Building::class)
                ->constrained()
                ->cascadeOnDelete();
            
            // Prevent Duplicate floors in a Building
            $table->unique(['building_id', 'name']);
            $table->unique(['building_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('floors');
    }
};
