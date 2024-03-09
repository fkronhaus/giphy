<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $default_users;
    public function run(): void
    {
        $this->default_users = [
            1 => [
                'name' => 'test1',
                'email' => 'test1@email.com',
                'password' => bcrypt('1234'),
                'access_type' => 1,
            ],
            2 => [
                'name' => 'test2',
                'email' => 'test2@email.com',
                'password' => bcrypt('2345'),
                'access_type' => 1,
            ],
        ];

        foreach ($this->default_users as $key => $user) {
            User::create($user);
        }
    }
}