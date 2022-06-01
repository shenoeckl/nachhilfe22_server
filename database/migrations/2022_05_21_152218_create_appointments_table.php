<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('status')->default("Offen");
            $table->string('starttime');
            $table->string('endtime');
            $table->timestamps();
            //Fremdschlüssel
            $table->foreignId('offer_id')->constrained()->onDelete("cascade");
            $table->foreignId('user_id')->constrained()->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
