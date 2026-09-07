<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'ani@hayenglish.test'],
            [
                'name' => 'Ani',
                'password' => 'password',
                'preferred_translation' => 'hy',
                'daily_goal' => 20,
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            WordSeeder::class,
            PhraseSeeder::class,
        ]);
    }
}
