<?php

class Create_Questions {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->text('question');
			$table->integer('user_id');
			$table->integer('quest_id');
			$table->integer('group_id');
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
		Schema::drop('questions');
	}

}