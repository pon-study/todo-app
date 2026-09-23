<?php

use App\Models\Todo;
use App\Models\Tag;
use App\Enums\Priority;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    // 優先度、タグ、ステータスのフィルタ条件を保持するための公開プロパティ（Web上でユーザーから見える）
    public string $priority = '';
    public string $tagId = '';
    public string $status = '';

    // タグを取得するロジック（サーバー側で処理し、その結果のみユーザーは見える）
    #[Computed] // #[Computed]:キャッシュ化する。同じリクエスト内で何度呼ばれても再計算しない。
    public function tags()
    {
        return Tag::all(); // タグを全て取得する
    }

    // 優先度を取得するロジック（サーバー側で処理し、その結果のみユーザーは見える）
    // Enumで定義している定数を全て取得する（High/Medium/Low）
    #[Computed]
    public function priorityOptions()
    {
        return Priority::cases();
    }

    // ステータスの値とラベルを連想配列で用意するロジック
    #[Computed]
    public function statusOptions()
    {
        return [
            '0'=>'未完了',
            '1'=>'完了',
        ];
    }

    // フィルター条件に一致するTodoを取得するロジック（サーバー側で処理し、その結果のみユーザーは見える）
    #[Computed]
    public function todos()
    {
        $query = Todo::with('tags');

        // 優先度のフィルター
        if ($this->priority !== ''){
            $query->ofPriority((int) $this->priority);
        }

        // タグのフィルター
        if ($this->tagId !== ''){
            $query->ofTag((int) $this->tagId);
        }
        
        // ステータスのフィルター
        if ($this->status !== ''){
            $query->ofStatus((bool) $this->status);
        }

        // フィルター条件に一致するTodoをTodoモデルファイルから取得する。
        // Todoの作成日時の降順で表示する
        return $query->orderBy('created_at','desc')->get();
    }
};
?>

<div>
    <div class="filter-bar">
        <div class="filter-group">
            <label class="filter-label">優先度</label>
            <select wire:model.live="priority" class="filter-select"> {{-- .liveをつけることで、プルダウンを選択した瞬間にサーバーへ送信される --}}
                <option value="">すべて</option>
                @foreach ($this->priorityOptions as $option)
                    <option value="{{ $option->value}}">{{ $option->label() }}</option> {{-- $option->valueは値、$option->labelは紐づくラベル（高、中、低など）--}}
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label">タグ</label>
            <select wire:model.live="tagId" class="filter-select"> {{-- .liveをつけることで、プルダウンを選択した瞬間にサーバーへ送信される --}}
                <option value="">すべて</option>
                @foreach ($this->tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label class="filter-label">ステータス</label>
            <select wire:model.live="status" class="filter-select"> {{-- .liveをつけることで、プルダウンを選択した瞬間にサーバーへ送信される --}}
                <option value="">すべて</option>
                @foreach ($this->statusOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        
    </div>
    <table class="data-table">
        <thead>
            <tr class="table-head-row">
                <th class="table-th">優先度</th>
                <th class="table-th">タイトル</th>
                <th class="table-th">説明</th>
                <th class="table-th">期限</th>
                <th class="table-th">状態</th>
                <th class="table-th">タグ</th>
                <th class="table-th">編集 / 削除</th>
            </tr>
        </thead>
        <tbody class="table-body">
            @forelse ($this->todos as $todo) {{-- forelseは、値が空の場合にemptyの内容を表示する --}}
            <tr>
                {{-- 優先度 --}}
                <td class="table-td">{{ $todo->priority?->label() }}</td> {{-- nullセーフ演算子を使用。表示する値がEnum（定義）から見つからない場合は何も表示しない --}}

                {{-- タイトル --}}
                <td class="table-td">{{ $todo->title }}</td> {{-- タイトルは必須項目のためnullセーフ演算子は未使用 --}}

                {{-- 説明 --}}
                <td class="table-td">{{ $todo->description }}</td>

                {{-- 期限（nullの場合は「未設定」） --}}
                <td class="table-td">{{ $todo->due_date?->format('Y/m/d') ?? '未設定'}}</td>{{-- nullableのため、nullの場合は未設定 --}}

                {{-- 完了状態（ステータス） --}}
                <td class="table-td">
                    @if ($todo->status) {{-- true or false のため、trueの場合は完了、falseの場合は未完了 --}}
                        <span class="badge-done">完了</span>
                    @else
                        <span class="badge-pending">未完了</span>
                    @endif
                </td>

                {{-- 紐づくタグを列挙 --}}
                <td class="table-td">
                    @foreach ($todo->tags as $tag)
                        <span class="badge-tag" style="color: {{$tag->color}};">#{{ $tag->name }}</span> {{-- タグ作成時に指定したカラーを表示する --}}
                    @endforeach
                </td>
                <td class="table-td-action">
                    <a href="{{ route('todos.edit', $todo->id) }}" class="link-edit">編集</a>
                    <span>/</span>
                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE') {{-- Laravelのresource上では、削除処理はDELETEリクエストとして扱うため、DELETEをhiddenで保持する --}}
                        <button type="submit" class="link-delete">削除</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty-state">該当するTodoはありません</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>