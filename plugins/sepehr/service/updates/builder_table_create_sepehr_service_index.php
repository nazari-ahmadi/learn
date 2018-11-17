<?php namespace Sepehr\Service\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateSepehrServiceIndex extends Migration
{
    public function up()
    {
        Schema::create('sepehr_service_index', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('user_id')->nullable();
            $table->integer('manager_id')->nullable();
            $table->text('packages')->nullable();
            $table->text('postmans')->nullable();
            $table->integer('operator_id')->nullable();
//            $table->integer('payment_type_id')->nullable();
            $table->dateTime('operator_recorded_at')->nullable();
            $table->dateTime('operator_received_at')->nullable();
            $table->text('payments')->nullable();
            $table->integer('status_id')->default(1);
            $table->string('sender_postal_code');
            $table->string('sender_address');
            $table->boolean('payment_status')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sepehr_service_index');
    }
}
