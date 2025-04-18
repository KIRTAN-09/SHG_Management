<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('group_name');
            $table->unsignedBigInteger('group_uid');
            $table->text('discussion');
            $table->text('attendance')->nullable(); // Added 'attendance' column
            // $table->string('photo')->nullable(); // Added 'photo' column
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_uid')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
