<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIgasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('igas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_uid')->nullable();
            // $table->text('description')->nullable();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->string('category1')->nullable();
            $table->decimal('earned1', 8, 2)->nullable();
            $table->string('category2')->nullable();
            $table->decimal('earned2', 8, 2)->nullable();
            $table->string('category3')->nullable();
            $table->decimal('earned3', 8, 2)->nullable();
            $table->softDeletes();

            $table->foreign('member_uid')->references('id')->on('members')->onDelete('set null');
        });

        // Add the new column 'activity'
        Schema::table('igas', function (Blueprint $table) {
            $table->string('activity')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove the new column 'activity'
        Schema::table('igas', function (Blueprint $table) {
            $table->dropColumn('activity');
            $table->dropColumn('category');
            $table->dropColumn('earned');
            $table->dropForeign(['member_uid']);
        });

        Schema::dropIfExists('igas');
    }
}
