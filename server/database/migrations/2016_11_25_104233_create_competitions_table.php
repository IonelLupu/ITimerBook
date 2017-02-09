<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competitions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('min_points');
            $table->boolean('finished',0);
            $table->datetime('starts_at');
            $table->datetime('ends_at');

            $table->string('bookToRead_name');
            $table->integer('bookToRead_pages');
            $table->string('bookToRead_author');

            $table->string('rewardBook_name');
            $table->string('rewardBook_author');
            $table->string('rewardBook_image');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
}
