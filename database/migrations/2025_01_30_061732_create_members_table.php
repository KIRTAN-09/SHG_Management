<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('number')->nullable();
            $table->string('village');
            $table->string('group');
            $table->string('caste');
            $table->decimal('share_price', 10, 2);
            $table->integer('share_quantity')->default(1);
            $table->enum('member_type', ['President', 'Secretary', 'Member']);
            $table->string('member_id')->unique();
            $table->timestamps();
            $table->enum('status', ['Active', 'Inactive']);
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }

    /**
     * Update the status of a member.
     */
    public function updateStatus($memberId, $status)
    {
        DB::table('members')
            ->where('member_id', $memberId)
            ->update(['status' => $status]);
    }
};

class AddGroupIdToMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('group_id');
        });
    }
}
