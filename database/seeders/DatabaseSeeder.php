<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Project;
use Illuminate\Support\Facades\Hash; // <-- import it at the top

use App\Models\User;
use App\Models\Role;
use App\Models\Task;
use App\Models\UserRole;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Categories
        Category::create([
            'category_name' => 'STAGES',
        ]);
        Category::create([
            'category_name' => 'PRIORITIES',
        ]);
        // STATUSES
        Category::create([
            'category_name' => 'Completed',
            'category_color' => 'bg-green-300',
            'parent_id' => 1,
        ]);
        Category::create([
            'category_name' => 'Not Started',
            'category_color' => 'bg-gray-500',
            'parent_id' => 1,
        ]);
        Category::create([
            'category_name' => 'In Progress',
            'category_color' => 'bg-blue-500',
            'parent_id' => 1,
        ]);
        Category::create([
            'category_name' => 'Cancelled',
            'category_color' => 'bg-red-500',
            'parent_id' => 1,
        ]);
        // PRIORITIES
        Category::create([
            'category_name' => 'High',
            'category_color' => 'bg-red-500',
            'parent_id' => 2,
        ]);
        Category::create([
            'category_name' => 'Medium',
            'category_color' => 'bg-orange-500',
            'parent_id' => 2,
        ]);
        Category::create([
            'category_name' => 'Low',
            'category_color' => 'bg-green-300',
            'parent_id' => 2,
        ]);
        // create company
        Company::create([
            'company_name' => 'Teamplo',
            'company_desc' => 'Company Managment Software', // ADMIN ACCOUNT
        ]);
        // create users
        User::factory()->create([
            'name' => 'Ahmet AKTA',
            'company_id' => 1,
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
     

        

        Department::factory(10)->create();
        Project::factory(40)->create();
        Task::factory(10)->create();
        $projects = Project::all();

        User::all()->each(function ($user) use ($projects) { 
            $user->projects()->attach(
                $projects->random(rand(1, 3))->pluck('id')->toArray()
            ); 
        });


        // Roles
        Role::create([
            'name' => 'Owner',
        ]);
        Role::create([
            'name' => 'Admin',
        ]);
        Role::create([
            'name' => 'Manager',
        ]);
        Role::create([
            'name' => 'Employee',
        ]);
        Role::create([
            'name' => 'HR',
        ]);
        Role::create([
            'name' => 'Finance',
        ]);
        Role::create([
            'name' => 'Content Creator',
        ]);

        $permissions = [
            'create user', 'edit user', 'delete user', 'view user',
            'assign role', 'revoke role', 'create role', 'edit role', 'delete role',
            'create project', 'edit project', 'delete project', 'view project',
            'create task', 'edit task', 'delete task', 'view task',
            'generate report', 'view report',
            'approve request', 'reject request', 'view request',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        UserRole::create(['user_id' => 1 , 'role_id' => 1]);
    }
}
