<?php

class Create_Groups {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->string('name', 200);
			$table->text('permissions');
			$table->string('code', 12);
			$table->boolean('active');
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
		Schema::drop('groups');
	}

}