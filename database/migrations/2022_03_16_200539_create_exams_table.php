<?php

use App\Models\Subject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Subject::class)->constrained()->onDelete('cascade');
            $table->dateTime('start_time', $precision = 0);
            $table->dateTime('end_time', $precision = 0);
            $table->integer('duration_minutes');
            $table->integer('mcq_easy_questionsNumber');
            $table->integer('mcq_medium_questionsNumber');
            $table->integer('mcq_hard_questionsNumber');
            $table->integer('tf_easy_questionsNumber');
            $table->integer('tf_medium_questionsNumber');
            $table->integer('tf_hard_questionsNumber');
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
        Schema::dropIfExists('exams');
    }
}
