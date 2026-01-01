<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkwhatlearnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workwhatlearns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('workshop_id')->nullable();
            $table->text('detail')->nullable();
            $table->enum('status',['1','0'])->nullable();
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
        Schema::dropIfExists('workwhatlearns');
    }
}
