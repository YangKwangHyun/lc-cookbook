<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Song;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::query()->factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Song::query()->create([
            'title' => 'Thriller',
            'artist' => 'Michael Jackson',
            'year' => 1982,
            'order' => 2,
        ]);

        Song::query()->create([
            'title' => 'Hey Jude',
            'artist' => 'The Beatles',
            'year' => 1968,
            'order' => 3,
        ]);

        Song::query()->create([
            'title' => 'Bohemian Rhapsody',
            'artist' => 'Queen',
            'year' => 1975,
            'order' => 1,
        ]);

        Song::query()->create([
            'title' => 'Never Gonna Give You Up',
            'artist' => 'Rick Astley',
            'year' => 1987,
            'order' => 6,
        ]);

        Song::query()->create([
            'title' => 'Always Be My Baby',
            'artist' => 'Mariah Carey',
            'year' => 1995,
            'order' => 5,
        ]);

        Song::query()->create([
            'title' => 'Lose Yourself',
            'artist' => 'Eminem',
            'year' => 2002,
            'order' => 4,
        ]);
    }
}
