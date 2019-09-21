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
            $table->dateTime('start_call_at');
            $table->dateTime('end_call_at')->nullable();
            $table->enum('type', ['ONDEMAND', 'PREORDER'])->default('ONDEMAND');
            $table->string('status');
            $table->text('notes')->nullable(); 
            // $table->integer('booking_fee')->default(0);
            $table->integer('translator_id')->nullable();
            $table->integer('origin_id');
            $table->integer('expertise_id')->nullable();
            $table->integer('requester_id')->nullable();
            $table->integer('requested_language_id');
            $table->integer('spoken_language_id')->nullable();
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
