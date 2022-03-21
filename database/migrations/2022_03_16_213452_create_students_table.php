<?php

use App\Models\Department;
use App\Models\Level_subjects;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_code')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('level');
            $table->foreignIdFor(Department::class);
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('students');
    }
}
