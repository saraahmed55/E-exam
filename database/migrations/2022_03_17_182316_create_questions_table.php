<?php

use App\Models\Chapters;
use App\Models\Question_difficulty;
use App\Models\Question_types;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Chapters::class);
            $table->enum('type', ['mcq','true or false']);
            $table->enum('difficulty', ['easy','medium', 'hard']);
            $table->string('question_text');
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
        Schema::dropIfExists('questions');
    }
}
