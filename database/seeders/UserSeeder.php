<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'default',
                'surname' => 'default',
                'email' => 'd@gmail.com',
                'password' => bcrypt('12345678'),
                'telephone' => '',
                'email_verified_at' => now(),
                'profile_photo_path' => 'https://via.placeholder.com/1024x1024.png/000088?text=ROOT',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        User::factory()->count(3)->create();
        $users = User::all();

        foreach ($users as $item ) {
            if ($item->id == 1) {
                $item->assignRole('root');
            }else {
                $item->assignRole('empleado');
            }
        }

    }
}