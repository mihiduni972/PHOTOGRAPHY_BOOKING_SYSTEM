<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents; // මෙය comment කර හෝ ඉවත් කර තැබිය හැක
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            // CategorySeeder එක AlbumSeeder එකට පෙර ධාවනය කිරීම වැදගත්,
            // මන්ද AlbumSeeder එක Category එක මත රඳා පවතින නිසා.
            CategorySeeder::class,
            AlbumSeeder::class,
            // PhotoSeeder::class, // ඔබට Photos Seeder එකක් තිබේ නම්
            ImageSeeder::class, // අලුතින් එකතු කර ඇත
        ]);
    }
}