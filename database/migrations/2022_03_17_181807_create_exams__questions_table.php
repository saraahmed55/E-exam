<?php

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
            $table->id();
            $table->foreignIdFor(Chapters::class);
            $table->foreignIdFor(Question_types::class);
            $table->foreignIdFor(Question_difficulty::class);
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
