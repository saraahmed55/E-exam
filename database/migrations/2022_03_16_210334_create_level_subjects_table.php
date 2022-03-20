<?php

use App\Models\Department;
use App\Models\Professor;
use App\Models\Subject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->foreignIdFor(Department::class);
            $table->foreignIdFor(Subject::class);
            $table->foreignIdFor(Professor::class);
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
        Schema::dropIfExists('level_subjects');
    }
}
