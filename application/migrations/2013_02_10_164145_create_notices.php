<?php

class Create_Notices {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notices', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id');
			$table->string('title', 255);
			$table->text('notification');
			$table->string('url', 255);
			$table->boolean('hidden');
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
		Schema::drop('notices');
	}

}