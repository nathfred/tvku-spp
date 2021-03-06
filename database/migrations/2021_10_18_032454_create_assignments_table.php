<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('type');
            $table->string('client')->nullable();
            $table->integer('nspp');
            $table->string('nspk')->nullable();
            $table->string('description')->nullable();
            $table->string('nominal')->nullable();
            $table->string('deadline');
            $table->text('info');
            $table->string('priority')->nullable();
            $table->date('created');
            $table->boolean('approval')->nullable();
            $table->date('approval_date')->nullable();
            $table->boolean('submit')->nullable(); // APAKAH SUDAH READY UNTUK DIBACA PAK GURUH
            $table->string('unique_id')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
