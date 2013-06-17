<?php

class Create_Posts {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id');
			$table->string('headline', 255);
			$table->text('post');
			$table->text('filename');
			$table->text('filedescriptions');
			$table->boolean('hidden');
			$table->boolean('frontpage');
			$table->boolean('menu');
			$table->integer('position');
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
		Schema::drop('posts');
	}

}