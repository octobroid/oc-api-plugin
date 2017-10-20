<?php namespace Octobro\API\Updates;

use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * This is the create oauth session scopes table migration class.
 */
class CreateOauthSessionScopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_session_scopes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('session_id')->unsigned();
            $table->string('scope_id', 40);

            $table->timestamps();

            $table->index('session_id');
            $table->index('scope_id');

            $table->foreign('session_id')
                  ->references('id')->on('oauth_sessions')
                  ->onDelete('cascade');

            $table->foreign('scope_id')
                  ->references('id')->on('oauth_scopes')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oauth_session_scopes', function (Blueprint $table) {
            $table->dropForeign('oauth_session_scopes_session_id_foreign');
            $table->dropForeign('oauth_session_scopes_scope_id_foreign');
        });
        Schema::drop('oauth_session_scopes');
    }
}
