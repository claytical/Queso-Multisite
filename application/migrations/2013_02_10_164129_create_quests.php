<?php

class Create_Quests {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('quests', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('group_id');
			$table->string('name', 255);
			$table->text('instructions');
			$table->integer('type');
			$table->string('category', 255);
			$table->boolean('allow_upload');
			$table->boolean('allow_text');
			$table->boolean('visible');
			$table->text('filename');
			$table->integer('position');
			$table->timestamps();
		});

		Schema::create('quest_user', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('quest_id');
			$table->string('note', 255);
			$table->timestamps();
		});

		Schema::create('quest_skill', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('quest_id');
			$table->integer('skill_id');
			$table->string('label', 255);
			$table->integer('amount');
		});
		
		Schema::create('quest_types', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->string('label', 255);
		});
		
		DB::table('quest_types')->insert(array(
		    'label'  => 'In Class'
		));

		DB::table('quest_types')->insert(array(
		    'label'  => 'Submission'
		));


		Schema::create('quest_lock', function($table) {
			// auto incremental id (PK)
			$table->increments('id');
			$table->integer('quest_id');
			$table->integer('skill_id');
			$table->integer('requirement');
		});




	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('quests');	
		Schema::drop('quest_user');	
		Schema::drop('quest_lock');	
		Schema::drop('quest_skill');	
		Schema::drop('quest_types');	

	}

}