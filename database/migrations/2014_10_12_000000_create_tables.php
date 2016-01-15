<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couriers', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('code');
			$table->string('label_preferences_json', 512)->default('{}');
			$table->softDeletes();
            $table->timestamps();
        });
		
        Schema::create('institutions', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('city');
			$table->string('state');
			$table->string('postal_code', 12)->nullable();
			$table->string('type')->nullable();
			$table->string('notes')->nullable();
			$table->string('oclc', 12)->nullable();
			$table->integer('courier_id')->unsigned();
			$table->string('hub', 12)->nullable();
			$table->string('site_code', 12)->nullable();
			$table->integer('service_length')->unsigned()->nullable();
			$table->boolean('inactive')->default(false);
            $table->timestamps();
			
			$table->foreign('courier_id')->references('id')->on('couriers');
        });
		
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique()->nullable();
			$table->integer('institution_id')->unsigned()->nullable();
            $table->string('password', 60);
            $table->rememberToken();
			$table->boolean('admin');
            $table->timestamps();
			
			$table->foreign('institution_id')->references('id')->on('institutions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
		Schema::drop('institutions');
		Schema::drop('couriers');
    }
}
