<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->text('source')->nullable();
            $table->string('provider')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('type')->nullable();
            $table->integer('category_id')->unsigned();
            $table->integer('views')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('featured_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
