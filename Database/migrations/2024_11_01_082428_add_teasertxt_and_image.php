<?php

use App\Contracts\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class AddTeasertxtAndImage
 */
class AddTeasertxtAndImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('', function (Blueprint $table) {
            Schema::table('ifatours_tours', function (Blueprint $table) {
                $table->string('teaser_img')->nullable();
            });
            Schema::table('ifatours_tours', function (Blueprint $table) {
                $table->string('teaser_txt')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('', function (Blueprint $table) {
            Schema::table('ifatours_tours', function (Blueprint $table) {
                $table->dropColumn('teaser_img');
            });
            Schema::table('ifatours_tours', function (Blueprint $table) {
                $table->dropColumn('teaser_txt');
            });
        });
    }
}
