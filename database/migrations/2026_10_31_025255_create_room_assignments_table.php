<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Room;
use App\Models\User;
use App\Models\Custodian;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Room::class)
                ->constrained()
                ->cascadeOnDelete();
            
            $table->foreignIdFor(User::class, 'professor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnUpdate();

            // Semester Tracking
            $table->string('school_year');
            $table->string('semester');

            // Schedule
            $table->tinyInteger('day_of_week');
            $table->time('start_time', 0);
            $table->time('end_time', 0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_assignments');
    }
};
