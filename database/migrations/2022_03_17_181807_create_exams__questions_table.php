<?php

use App\Models\Exams;
use App\Models\Chapters;
use App\Models\Question_difficulty;
use App\Models\Question_types;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams__questions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignIdFor(Exams::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Chapters::class)->constrained()->onDelete('cascade');
            $table->enum('type', ['mcq','true or false']);
            $table->enum('difficulty', ['easy','medium', 'hard']);
            $table->integer('Question_number');
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
        Schema::dropIfExists('exams__questions');
    }
}
