<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Group;
use App\Models\Task;
use App\Models\Time;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Task::factory(2)->create();
        User::factory(3)->create();
        Group::factory(2)->create();

         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@test.com',
             'role' => 'admin'
         ]);
    }
}
