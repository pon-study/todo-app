<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Todo; // Tagモデル
use Illuminate\Database\Seeder; // Todoモデル

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // タグをname指定で取得（TagSeederが先に実行されている前提）
        $shopping = Tag::where('name', '買い物')->first();
        $work = Tag::where('name', '仕事')->first();
        $private = Tag::where('name', 'プライベート')->first();

        $todo1 = Todo::create([
            'title' => '牛乳を買う',
            'description' => 'スーパーで2本',
            'priority' => 1,
            'due_date' => now()->addDays(2),
            'status' => false,
        ]);
        $todo1->tags()->sync([$shopping->id]); // 中間テーブルを同期

        $todo2 = Todo::create([
            'title' => '資料作成',
            'description' => '来週の会議用スライド',
            'priority' => 2,
            'due_date' => now()->addDays(5),
            'status' => false,
        ]);
        $todo2->tags()->sync([$work->id]);

        $todo3 = Todo::create([
            'title' => '部屋の掃除',
            'priority' => 3,
            'due_date' => now()->subDays(1),
            'status' => true,
        ]);
        $todo3->tags()->sync([$private->id, $shopping->id]);

        $todo4 = Todo::create([
            'title' => '優先度・期限なしのタスク',
        ]);
    }
}
