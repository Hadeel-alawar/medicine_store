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
        Schema::create('med_fav_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId("fav_id")->constrained("favourites");
            $table->foreignId("medication_id")->constrained("medications");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('med_fav_pivot');
    }
};
