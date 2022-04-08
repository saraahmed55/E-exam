<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create(
            ['name'=>'Software Engineering']
        );
        Department::create(
            ['name'=>'Computer Science']
        );
        Department::create(
            ['name'=>'Information Technology']
        );
        Department::create(
            ['name'=>'Information Systems']
        );
        Department::create(
            ['name'=>'Bio Informatics']
        );
        Department::create(
            ['name'=>'General']
        );
    }
}
