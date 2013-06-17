<?php

class Create_Comments {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('submission_id');
			$table->integer('user_id');
			$table->integer('commenter_id');
			$table->integer('quest_id');
			$table->text('comment');
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
		Schema::drop('comments');
	}

}