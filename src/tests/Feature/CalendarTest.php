<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_カレンダー画面が表示できる(): void
    {
        $response = $this->get(route('calendar.index'));

        // 期待結果：正常（200）
        $response->assertStatus(200);
    }

    public function test_todo（期限設定あり）カレンダーのイベントに含まれる(): void
    {
        $todo = Todo::create([
            'title' => 'テスト',
            'due_date' => '2026-09-30',
        ]);

        // 'calendar' は ⚡calendar.blade.php のファイル名から自動で決まるコンポーネント名
        Livewire::test('calendar')
            ->assertSee($todo->title);
    }

    public function test_todo（期限設定なし）はカレンダーのイベントに含まれない(): void
    {
        $todo = Todo::create(['title' => 'テスト']);

        Livewire::test('calendar')
            ->assertDontSee($todo->title);
    }
}
