<?php

class Create_Answers {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->text('answer');
			$table->integer('thanks');
			$table->integer('question_id');
			$table->integer('user_id');
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
		Schema::drop('answers');
	}

}