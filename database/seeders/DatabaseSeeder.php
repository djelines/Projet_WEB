<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\Task;
use App\Models\Cohort; 
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\UserSchool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the default user
        $admin = User::create([
            'last_name'     => 'Admin',
            'first_name'    => 'Admin',
            'email'         => 'admin@codingfactory.com',
            'password'      => Hash::make('123456'),
        ]);

        $teacher = User::create([
            'last_name'     => 'Teacher',
            'first_name'    => 'Teacher',
            'email'         => 'teacher@codingfactory.com',
            'password'      => Hash::make('123456'),
        ]);

        $user = User::create([
            'last_name'     => 'Student',
            'first_name'    => 'Student',
            'email'         => 'student@codingfactory.com',
            'password'      => Hash::make('123456'),
        ]);

        $user2 = User::create([
            'last_name'     => 'Student',
            'first_name'    => 'Student',
            'email'         => 'student2@codingfactory.com',
            'password'      => Hash::make('123456'),
        ]);

        // Create the default school
        $school = School::create([
            'user_id'   => $user->id,
            'name'      => 'Coding Factory',
        ]);
        

        // Create the admin role
        UserSchool::create([
            'user_id'   => $admin->id,
            'school_id' => $school->id,
            'role'      => 'admin'
        ]);

        // Create the teacher role
        UserSchool::create([
            'user_id'   => $teacher->id,
            'school_id' => $school->id,
            'role'      => 'teacher'
        ]);

        // Create the student role
        UserSchool::create([
            'user_id'   => $user->id,
            'school_id' => $school->id,
            'role'      => 'student'
        ]);

        UserSchool::create([
            'user_id'   => $user2->id,
            'school_id' => $school->id,
            'role'      => 'student'
        ]);

        $promo1 = Cohort::create([
            'school_id' => 1, // adapte selon ta base
            'name' => 'Promo 1',
            'description' => 'Cohorte de première année',
            'start_date' => now()->subMonths(6),
            'end_date' => now()->addMonths(6),
        ]);
        
        $promo2 = Cohort::create([
            'school_id' => 1,
            'name' => 'Promo 2',
            'description' => 'Cohorte de deuxième année',
            'start_date' => now()->subMonths(18),
            'end_date' => now()->subMonths(6),
        ]);

        DB::table('cohort_user')->insert([
            [
                'user_id' => $user->id, // student
                'cohort_id' => $promo1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $admin->id,
                'cohort_id' => $promo1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $admin->id,
                'cohort_id' => $promo2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $teacher->id,
                'cohort_id' => $promo1->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $user2->id,
                'cohort_id' => $promo2->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        

        // Create Task
        $tasks = Task::factory()->count(16)->create();
        foreach ($tasks as $task) {
            $task->cohorts()->attach(fake()->randomElement([$promo1->id, $promo2->id]));
        }
    }
}
