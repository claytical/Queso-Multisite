<?php

class Create_Users {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->string('username', 200);
			$table->string('email',200);
			$table->string('photo', 400);
			$table->string('password', 200);
			$table->string('password_reset_hash', 200);
			$table->string('temp_password', 200);
			$table->string('remember_me', 200);
			$table->string('activation_hash', 200);
			$table->string('ip_address', 200);
			$table->string('status', 200);
			$table->boolean('notify_email');
			$table->string('activated', 200);
			$table->boolean('super');
			$table->text('permissions');
			$table->timestamps();
		});

		Schema::create('users_groups', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('group_id');
			$table->boolean('active');
			$table->boolean('instructor');
		});


	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
		Schema::drop('users_groups');
	}

}