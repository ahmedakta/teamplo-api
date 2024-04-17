<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash; // <-- import it at the top

use App\Models\User;
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
        Task::factory(10)->create();

        User::factory()->create([
            'name' => 'Ahmet AKTA',
            'email' => 'ahmdekta@gmail.com',
            'password' => bcrypt('asdasdasd'),
        ]);
    }
}
