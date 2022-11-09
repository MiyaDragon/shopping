<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => '顧客',
            'email' => 'user@a.com',
            'password' => Hash::make('pass'),
            'image_path' => UploadedFile::fake()->image('test.jpg')
        ]);
        User::factory()
            ->count(19)
            ->create();
    }
}
