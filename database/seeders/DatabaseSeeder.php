<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use App\Models\Project;
use Illuminate\Support\Facades\Hash; // <-- import it at the top

use App\Models\User;
use App\Models\Role;
use App\Models\Task;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // create users
        User::factory()->create([
            'name' => 'Ahmet AKTA',
            'role_id' => 1, // ADMIN ACCOUNT
            'email' => 'ahmdekta@gmail.com',
            'image' => 'default_profile_image.png',
            'password' => bcrypt('asdasdasd'),
        ]);
        
        User::factory()->create([
            'name' => 'Content Creator',
            'role_id' => 3, // Content Creator ACCOUNT
            'email' => 'contentcreator@gmail.com',
            'image' => 'default_profile_image.png',
            'password' => bcrypt('asdasdasd'),
        ]);
        // random users
        User::factory(20)->create();
        // assign projects to users
     

        // create company
        Company::create([
            'user_id' => 1,
            'company_name' => 'Teamplo',
            'company_desc' => 'Company Managment Software', // ADMIN ACCOUNT
        ]);

        Department::factory(10)->create();
        Project::factory(10)->create();
        Task::factory(10)->create();
        $projects = Project::all();

        User::all()->each(function ($user) use ($projects) { 
            $user->projects()->attach(
                $projects->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });


        // Roles
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'User',
        ]);
        Role::create([
            'name' => 'Content Creator',
        ]);
    }
}
