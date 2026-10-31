<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Floor;
use App\Models\Custodian;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code');
            $table->string('room_type');

            $table->foreignIdFor(Floor::class)
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignIdFor(Custodian::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            
            $table->boolean('is_available')
                ->default(false);
            
            // Specifications of Room
            $table->json('equipment')
                ->nullable();

            $table->integer('power_outlets')
                ->default(0);

            $table->integer('fans')
                ->default(0);

            $table->integer('air_conditioners')
                ->default(0);
            
            $table->string('other')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
