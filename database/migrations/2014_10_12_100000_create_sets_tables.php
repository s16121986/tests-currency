<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up()
	{
		Schema::create('custom_sets', function (Blueprint $table) {
			$table->mediumInteger('id')->unsigned()->autoIncrement();
			$table->string('description', 225)->nullable();
			$table->timestamps();
		});

		Schema::create('custom_set_currencies', function (Blueprint $table) {
			$table->mediumInteger('set_id')->unsigned();
			$table->string('currency', 3);

			$table->primary(['set_id', 'currency']);
			$table->foreign('set_id', 'custom_set_currencies_fkey_set_id')
				->references('id')
				->on('custom_sets')
				->cascadeOnDelete()
				->cascadeOnUpdate();
		});
	}

	public function down()
	{
		Schema::dropIfExists('custom_set_currencies');
		Schema::dropIfExists('custom_sets');
	}
};
