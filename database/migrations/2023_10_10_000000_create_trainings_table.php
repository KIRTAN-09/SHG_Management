<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingsTable extends Migration
{
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->date('training_date');
            $table->string('trainer');
            $table->string('member_id')->nullable(); // Allow null values for member_id
            $table->string('members_name')->nullable(); // Allow null values for members_name
            $table->string('location');
            $table->string('category');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('trainings');
    }
}
