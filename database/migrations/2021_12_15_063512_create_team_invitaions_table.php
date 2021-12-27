<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamInvitaionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('email');
            $table->enum('role', ['admin', 'member', 'viewer']);
            $table->enum('type', ['candidate', 'user']);
            $table->timestamps();

            $table->unique(['team_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('team_invitaions');
    }
}
