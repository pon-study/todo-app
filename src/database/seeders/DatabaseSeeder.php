<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TagSeeder::class, // タグのテストデータを先に実行
            TodoSeeder::class, // Todoのテストデータを実行（タグを作成していることが前提なので後ろに記載）
        ]);
    }
}
