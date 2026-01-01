<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title', 191)->nullable();
				$table->text('short_detail', 65535)->nullable();
				$table->text('detail', 65535)->nullable();
				$table->text('requirement', 65535)->nullable();
				$table->string('price', 191)->nullable();
				$table->string('discount_price', 191)->nullable();
				$table->string('video', 191)->nullable();
				$table->string('url', 191)->nullable();
				$table->enum('featured', array('1','0'))->nullable();
				$table->string('slug', 191)->nullable();
				$table->enum('status', array('1','0'))->nullable();
				$table->string('preview_image', 191)->nullable();
				$table->string('preview_type', 191)->nullable();
				$table->enum('type', array('1','0'))->nullable();
				$table->integer('duration')->nullable();
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
        Schema::dropIfExists('workshops');
    }
}
