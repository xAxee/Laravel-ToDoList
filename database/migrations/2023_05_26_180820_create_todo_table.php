<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo', function (Blueprint $table) {
            $table->id();
            $table->string("title", 100);
            $table->string("description", 1000);
            $table->integer("task_status");
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            //$table->foreignId('group_id')->constrained('group')->onDelete('cascade');
            $table->integer('group_id')->unsigned()->nullable();
            $table->integer('assigned_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('todo', function (Blueprint $table) {
            // TODO
            // Ogarnac dlaczego to nie dziala
            // $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo');
    }
};
