<?php

class Create_Levels {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('levels', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('group_id');
			$table->integer('amount');
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
		Schema::drop('levels');
	}

}