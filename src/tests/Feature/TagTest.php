<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_タグ管理の表示できる(): void
    {
        $response = $this->get(route('tags.index'));

        // 期待結果：正常（200）ステータス
        $response->assertStatus(200);
    }

    public function test_タグの新規登録できる(): void
    {
        $response = $this->post(route('tags.store'), [
            'name' => 'テスト',
            'color' => '#FF0000',
        ]);

        $response->assertRedirect(route('tags.index'));

        // 期待結果：名前が「テスト」、カラーが「FF0000」
        $this->assertDatabaseHas('tags', [
            'name' => 'テスト',
            'color' => '#FF0000',
        ]);
    }

    public function test_nameの必須エラーになる(): void
    {
        $response = $this->post(route('tags.store'), [
            'color' => '#FF0000',
        ]);

        $response->assertSessionHasErrors('name');
        // 期待結果：レコードが作成されていないこと
        $this->assertDatabaseCount('tags', 0);
    }

    public function test_タグ更新できる(): void
    {
        $tag = Tag::create([
            'name' => 'テスト',
            'color' => '#FF0000',
        ]);

        $response = $this->put(route('tags.update', $tag->id), [
            'name' => 'テスト更新',
        ]);

        $response->assertRedirect(route('tags.index'));

        // 期待結果：レコードのタイトルが更新されていること
        $this->assertDatabaseHas('tags', [
            'id' => $tag->id,
            'name' => 'テスト更新',
        ]);
    }

    public function test_タグ削除できる(): void
    {
        $tag = Tag::create(['name' => '削除予定タグ']);

        $response = $this->delete(route('tags.destroy', $tag->id));

        $response->assertRedirect(route('tags.index'));

        // 期待結果：レコードが見つからない
        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }
}
