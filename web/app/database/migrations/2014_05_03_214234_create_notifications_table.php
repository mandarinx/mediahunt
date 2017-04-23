<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function ($t)
        {
            $t->increments('id');
            $t->string('type');
            $t->string('user_id');
            $t->string('from_id');
            $t->string('reason');
            $t->string('on_id')->nullable();
            $t->timestamp('seen_at')->nullable();
            $t->timestamps();
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
