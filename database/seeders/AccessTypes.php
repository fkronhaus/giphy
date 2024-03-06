<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\access_type;

class AccessTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    static $access_types = [
        'Web',
        'Google',
    ];
    public function run(): void
    {
        foreach(self::$access_types as $value){
            access_type::create(
                [
                    'name' => $value
                ]
            );
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
