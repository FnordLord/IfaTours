<?php

use App\Contracts\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateIfatoursTables
 */
class CreateIfatoursTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Touren-Tabelle erstellen
        Schema::create('ifatours_tours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('award_id')->nullable();
            $table->timestamps();
        });

        // Legs-Tabelle erstellen
        Schema::create('ifatours_legs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tour_id');
            $table->string('flight_id');
            $table->integer('order')->default(0);
            $table->timestamps();

            // Constraints hinzufügen
            $table->foreign('tour_id')->references('id')->on('ifatours_tours')->onDelete('cascade');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
        });

        // Tabelle für Benutzer-Fortschritt erstellen
        Schema::create('ifatours_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('tour_id');
            $table->string('flight_id');
            $table->boolean('completed')->default(false);
            $table->timestamps();

            // Constraints hinzufügen
            $table->foreign('tour_id')->references('id')->on('ifatours_tours')->onDelete('cascade');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ifatours_progress');
        Schema::dropIfExists('ifatours_legs');
        Schema::dropIfExists('ifatours_tours');
    }
}
