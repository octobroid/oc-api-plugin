<?php namespace Octobro\API\Updates;

use October\Rain\Database\Updates\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * This is the create oauth refresh tokens table migration class.
 */
class CreateOauthRefreshTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 40)->unique();
            $table->string('access_token_id', 40)->primary();
            $table->integer('expire_time');

            $table->timestamps();

            $table->foreign('access_token_id')
                  ->references('id')->on('oauth_access_tokens')
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
        Schema::table('oauth_refresh_tokens', function (Blueprint $table) {
            $table->dropForeign('oauth_refresh_tokens_access_token_id_foreign');
        });

        Schema::drop('oauth_refresh_tokens');
    }
}
