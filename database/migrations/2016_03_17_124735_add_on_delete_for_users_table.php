<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnDeleteForUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('users', function ($table) {
			$table->dropForeign('users_institution_id_foreign');
			$table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('users', function ($table) {
			$table->dropForeign('users_institution_id_foreign');
			$table->foreign('institution_id')->references('id')->on('institutions');
		});
    }
}
