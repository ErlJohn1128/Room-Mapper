<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('rooms', 'for_use')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->boolean('for_use')->default(true);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('rooms', 'for_use')) {
            Schema::table('rooms', function (Blueprint $table) {
                $table->dropColumn('for_use');
            });
        }
    }
};
