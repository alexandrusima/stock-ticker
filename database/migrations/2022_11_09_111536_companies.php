<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('companies', static function (Blueprint $table) {
			$table->id();
			$table->string('name', 255)->nullable(false);
			$table->string('status', 20);
			$table->string('symbol')->nullable(false)->unique();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropTable('companies');
    }
};
