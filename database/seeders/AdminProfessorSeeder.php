<?php

namespace Database\Seeders;

use App\Models\Professor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminProfessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Professor::create([
            'prof_code'=>'111111','first_name'=>'Admin','last_name'=>'Admin','email'=>'Admin123@gmail.com','department_id'=>'1','password'=>Hash::make('Admin123'),'roles_id'=>'1'
        ]);
    }
}
