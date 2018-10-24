<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClothersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name','20')->comment('衣物名称');
            $table->string('desc','20')->comment('描述');
            $table->integer('cat_id')->comment('分类id');
            $table->string('price')->comment('价格');
            $table->integer('season')->comment('季节@1:春季 @2:夏季 @3：秋季 @4：冬季');
            $table->string('img_path')->comment('图片地址');
            $table->softDeletes();
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
        Schema::dropIfExists('clothes');
    }
}
