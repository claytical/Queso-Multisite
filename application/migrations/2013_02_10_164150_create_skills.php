<?php

class Create_Skills {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('skills', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('group_id');
			$table->string('name', 255);
			$table->timestamps();
		});

		Schema::create('skill_user', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('skill_id');
			$table->integer('group_id');
			$table->integer('quest_id');
			$table->integer('amount');
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
		Schema::drop('skills');
		Schema::drop('skill_user');
	}

}