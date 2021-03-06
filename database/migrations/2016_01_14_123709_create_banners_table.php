<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->tinyInteger('banner_position');//0->主页 1--->约惠
            $table->tinyInteger('type');//0->主题,1->专题，2-》活动
            $table->integer('item_id')->nullable();//收藏的内容对应的id
            $table->string('path');
            $table->string('detail_image');
            $table->integer('order');
            $table->string('action');
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
        Schema::drop('banners');
    }
}
