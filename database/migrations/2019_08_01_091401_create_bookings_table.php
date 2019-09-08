<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->nullable()->index();
            //$table->string('origin')->nullable();
            $table->enum('origin',['user','admin'])->nullable();
            $table->date('booking_date')->nullable();
            $table->time('booking_time')->nullable();
           // $table->float('call_duration')->nullable();
            $table->time('end_call')->nullable();
            $table->text('notes')->nullable();
            $table->string('language')->nullable();     
            $table->string('translator_id')->nullable();
            $table->integer('origin_id')->nullable();
            $table->integer('expertise_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('status')->nullable();    
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
        Schema::dropIfExists('bookings');
    }
}
