<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\College;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code');

            // Operating Hours
            $table->time('start_time', 0);
            $table->time('end_time', 0);

            $table->foreignIdFor(College::class)
                ->constrained()
                ->cascadeOnDelete();

            // Prevents Duplicate in Same College
            $table->unique(['college_id', 'name']);
            $table->unique(['college_id', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
