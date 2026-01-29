<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trackings', function (Blueprint $table) {
            $table->string('description_1')->nullable();
            $table->string('description_2')->nullable();
            $table->string('description_3')->nullable();
        });

       
    }

    public function down()
    {
        Schema::table('trackings', function (Blueprint $table) {
            $table->dropColumn(['description_1', 'description_2', 'description_3']);
        });

        
    }
};