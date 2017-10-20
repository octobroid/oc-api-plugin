<?php namespace Octobro\API\Updates;

use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * This is the create oauth client endpoints table migration class.
 *
 */
class CreateOauthClientEndpointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_client_endpoints', function (Blueprint $table) {
            $table->increments('id');
            $table->string('client_id', 40);
            $table->string('redirect_uri');

            $table->timestamps();

            $table->unique(['client_id', 'redirect_uri']);

            $table->foreign('client_id')
                ->references('id')->on('oauth_clients')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_client_endpoints', function (Blueprint $table) {
            $table->dropForeign('oauth_client_endpoints_client_id_foreign');
        });

        Schema::drop('oauth_client_endpoints');
    }
}
