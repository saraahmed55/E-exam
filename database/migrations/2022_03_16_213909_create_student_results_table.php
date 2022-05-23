<?php

use App\Models\Student;
use App\Models\Exams;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_results', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignIdFor(Student::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Exams::class)->constrained()->onDelete('cascade');
            $table->integer('result');
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
        Schema::dropIfExists('student_results');
    }
}
