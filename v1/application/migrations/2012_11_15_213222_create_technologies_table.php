<?php

class Create_Technologies_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('technologies', function($table) {
		    $table->increments('id');
		    $table->string('name', 128);
		    $table->string('description', 255);
		    $table->string('image', 255);
		    $table->integer('points');
		    $table->timestamps();
		    $table->boolean('active')->default(true);
			$table->integer('order')->nullable();
		});
		DB::table('technologies')->insert(array(
		    'name'  => 'Laravel',
		    'description'  => 'A PHP Framework for Web Artisans.',
		    'image'  => 'laravel.png',
		    'points'  => '1',
		    'created_at' => date('Y-m-d H:i:s'),
		    'updated_at' => date('Y-m-d H:i:s')
		));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('technologies');		
	}

}