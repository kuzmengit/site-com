<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Comments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
    //id, on_blog, from_user, body, at_time
		Schema::create('comments', function(Blueprint $table){
			$table->increments('id');
			$table->integer('post_id')->unsigned()->default(0);
			$table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
			$table->integer('user_id')->unsigned()->default(0);
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->text('body');
			$table->timestamps();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    // drop comment
		Schema::drop('comments');
	}
}
