<?php

class Create_Variables {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('variables', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('group_id');
			$table->string('label', 255);
			$table->timestamps();
		});

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('variables');
	}

}