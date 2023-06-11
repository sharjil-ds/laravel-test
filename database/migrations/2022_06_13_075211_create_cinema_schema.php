<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a laravel migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
        /**
         * Create movies table
         */
        if (!Schema::hasTable('movies')) {
            Schema::create('movies', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->text('description');
                $table->time('duration');
                $table->timestamps();
            });
        }

        /**
         * Create cinemas table
         */
        if (!Schema::hasTable('cinemas')) {
            Schema::create('cinemas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->text('address');
                $table->timestamps();
            });
        }

        /**
         * Create shows table
         */
        if (!Schema::hasTable('shows')) {
            Schema::create('shows', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('movie_id')->unsigned();
                $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
                $table->integer('cinema_id')->unsigned();
                $table->foreign('cinema_id')->references('id')->on('cinemas')->onDelete('cascade');
                $table->time('show_time');
                $table->integer('booked_seats')->default('0');
                $table->timestamps();
            });
        }

         /**
         * Create pricing table
         */
        if (!Schema::hasTable('pricing')) {
            Schema::create('pricing', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('show_id')->unsigned();
                $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
                $table->double('price', 8, 2);
                $table->timestamps();
            });
        }

        /**
         * Create seats table
         */
        if (!Schema::hasTable('seats')) {
            Schema::create('seats', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('show_id')->unsigned();
                $table->foreign('show_id')->references('id')->on('shows')->onDelete('cascade');
                $table->integer('seat_number')->unsigned();
                $table->enum('seat_type', ['VIP', 'COUPLE', 'SUPER_VIP']);
                $table->boolean('is_booked')->default(0);
                $table->timestamps();
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
        Schema::dropIfExists('cinemas');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('pricing');
        Schema::dropIfExists('seats');

    }
}
