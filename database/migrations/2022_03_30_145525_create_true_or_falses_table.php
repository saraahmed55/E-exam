<?php

use App\Models\Chapters;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrueOrFalsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('true_or_falses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Chapters::class)->onDelete('cascade');
            $table->enum('difficulty', ['easy','medium', 'hard']);
            $table->string('question_text');
            $table->enum('CorrectAnswer', ['true','false']);
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
        Schema::dropIfExists('true_or_falses');
    }
}
