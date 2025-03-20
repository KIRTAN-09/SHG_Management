<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            // $table->string('group_id')->nullable();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade'); // Ensure this is correct
            // $table->string('group_name')->nullable(); // New column for group name
            $table->string('member_name'); // Ensure member_name is required and not nullable
            $table->decimal('amount', 8, 2);
            $table->date('date_of_deposit'); // Ensure correct date field is defined
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('savings');
    }
}
