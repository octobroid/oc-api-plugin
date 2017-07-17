<?php namespace Octobro\API\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOAuthClientsTable extends Migration
{
    public function up()
    {
        Schema::create('octobro_api_o_auth_clients', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('octobro_api_o_auth_clients');
    }
}
