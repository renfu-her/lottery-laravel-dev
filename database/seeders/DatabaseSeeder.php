<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 生成100个用户,名称为"员工1"到"员工100",邮箱为"user1@gmail.com"到"user100@gmail.com"
        for ($i = 1; $i <= 100; $i++) {
            User::factory()->create([
                'name' => '員工' . $i,
                'email' => 'user' . $i . '@gmail.com',
            ]);
        }

    }
}
