<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder; // Tagモデルが対象

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create(['name' => '買い物', 'color' => '#FF0000']);
        Tag::create(['name' => '仕事', 'color' => '#0000FF']);
        Tag::create(['name' => 'プライベート', 'color' => '#00FF00']);
    }
}
