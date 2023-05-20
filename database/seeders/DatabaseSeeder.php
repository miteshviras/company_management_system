<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->create_admin();
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }

    private function create_admin(string $email = 'admin@example.com',string $password = "admin@123"): void
    {
        $userExist = User::where('email',$email)->first();
        if(empty($userExist))
        User::create([
            'name' => 'admin',
            'email' => $email,
            'password' => bcrypt($password),
            'is_admin' => 1
        ]);
    }
}
