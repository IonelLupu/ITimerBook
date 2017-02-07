<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelSchemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create( 'model_schemas', function ( Blueprint $table ) {

		    $table->increments( 'id' );
		    $table->string( 'name' );
		    $table->text( 'schema' );
		    $table->timestamps();

	    } );

	    DB::insert('insert into model_schemas ( `name`, `schema`) values (?, ?)', [
	    	"User",
		    '{"name":{"type":"String"},"email":{"type":"String"},"password":{"type":"String","table":{"visible":false},"form":{"visible":false}}}'
	    ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

	    Schema::dropIfExists('model_schemas');
    }
}
