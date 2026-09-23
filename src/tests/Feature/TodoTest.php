<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    // テストDBのマイグレーションをリフレッシュ
    use RefreshDatabase;

    /**
     * Todo一覧画面が表示できることを確認
     */
    public function test_todo一覧画面を表示できる(): void
    {
        $response = $this->get(route('todos.index'));

        $response->assertStatus(200); // 期待結果：200ステータスになる
    }

    /**
     * Todoを新規登録できることを確認
     */
    public function test_todoを新規登録できる(): void
    {
        $response = $this->post(route('todos.store'), [
            'title' => 'テストタイトル',
            'priority' => 1,
        ]);

        // 一覧画面へリダイレクト
        $response->assertRedirect(route('todos.index'));

        // 期待結果：タイトルが「テストタイトル」、優先度が高（１）になっていること
        $this->assertDatabaseHas('todos', [
            'title' => 'テストタイトル',
            'priority' => 1,
        ]);
    }

    /**
     * 必須項目（title）が無い場合はバリデーションエラーになることを確認
     */
    public function test_titleが無い場合は新規登録に失敗する(): void
    {
        $response = $this->post(route('todos.store'), [
            'priority' => 1,
        ]);

        // バリデーションエラー時はセッションにエラーが積まれる
        $response->assertSessionHasErrors('title');

        // 期待結果：レコードが作成されていないことを確認
        $this->assertDatabaseCount('todos', 0);
    }

    /**
     * Todoを更新できることを確認
     */
    public function test_todoを更新できる(): void
    {
        $todo = Todo::create([
            'title' => '牛乳を買う',
            'priority' => 1,
        ]);

        $response = $this->put(route('todos.update', $todo->id), [
            'title' => '牛乳とパンを買う',
        ]);

        $response->assertRedirect(route('todos.index'));

        // 期待結果：レコードが更新されていることを確認
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => '牛乳とパンを買う',
        ]);
    }

    /**
     * Todoを削除できることを確認
     */
    public function test_todoを削除できる(): void
    {
        $todo = Todo::create([
            'title' => 'テスト用Todo',
        ]);

        $response = $this->delete(route('todos.destroy', $todo->id));

        $response->assertRedirect(route('todos.index'));

        // 期待結果：レコードが見つからないことを確認
        $this->assertDatabaseMissing('todos', ['id' => $todo->id]);
    }
}
