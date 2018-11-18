<?php namespace Sepehr\wallet\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSepehrWallet extends Migration
{
    public function up()
    {
        Schema::create('sepehr_wallet_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('payments')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sepehr_wallet_');
    }
}
