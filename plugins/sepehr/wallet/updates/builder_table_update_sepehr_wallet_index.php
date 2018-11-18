<?php namespace Sepehr\wallet\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateSepehrWalletIndex extends Migration
{
    public function up()
    {
        Schema::table('sepehr_wallet_index', function($table)
        {
            $table->bigInteger('user_id')->unsigned();
            $table->string('wallet_charge')->default('0');
        });
    }
    
    public function down()
    {
        Schema::table('sepehr_wallet_index', function($table)
        {
            $table->dropColumn('user_id');
            $table->dropColumn('wallet_charge');
        });
    }
}
