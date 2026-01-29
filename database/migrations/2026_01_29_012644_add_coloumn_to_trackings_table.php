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
       Schema::table('trackings', function (Blueprint $table) {
            $table->string('sender')->nullable();
            $table->string('courier')->nullable();
            $table->string('receiver')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trackings', function (Blueprint $table) {
            $table->dropColumn(['sender', 'courier', 'receiver']);
        });
    }
};
