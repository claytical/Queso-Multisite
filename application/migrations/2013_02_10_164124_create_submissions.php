<?php

class Create_Submissions {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('submissions', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('quest_id');
			$table->text('submission');
			$table->text('filename');
			$table->boolean('graded');
			$table->boolean('visible');
			$table->integer('revision');
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
		Schema::drop('submissions');	
	}

}