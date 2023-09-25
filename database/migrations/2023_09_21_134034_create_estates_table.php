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
        Schema::create('estates', function (Blueprint $table) {
            $table->id();

            $table->string('title')->required();
            $table->text('description');
            $table->string('cover');
            $table->unsignedTinyInteger('rooms')->default(1)->required();
            $table->unsignedTinyInteger('beds')->default(1)->required();
            $table->unsignedTinyInteger('bathrooms')->default(1)->required();
            $table->unsignedSmallInteger('mq')->required();
            $table->float('price');
            $table->string('address')->required();
            $table->string('coordinates_long')->required();
            $table->string('coordinates_lat')->required();
            $table->boolean('is_visible');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estates');
    }
};
