<?php

namespace App\Models;

use App\Enums\Priority;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    // INSERT時の一括代入可能なカラムを指定
    protected $fillable = ['title', 'description', 'priority', 'due_date', 'status'];

    // castsはEloquentの仕組みの一つ
    // DB->PHP, PHP->DBの双方向で、指定した型に変換するメソッド
    protected $casts = [
        'due_date' => 'date', // PHP側では、Carbonという日付操作専用のオブジェクトへ変換される。Y年M月D日というformatの整形が楽になる。
        'status' => 'boolean', // PHP側では、false,trueとして扱うように明示できる。
        'priority' => Priority::class, // 優先度に関するEnumの定数クラスとして明示
    ];

    // Tagテーブルとの多対多を指定（中間テーブルの自動JOIN）
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // 優先度で絞り込む
    public function scopeOfPriority(Builder $query, int $priority): Builder
    {
        return $query->where('priority', $priority);
    }

    // 指定したタグのIDをtag_todo中間テーブル経由でwhere句に追加
    // tagsはTodoモデル内のtags関数を参照している
    public function scopeOfTag(Builder $query, int $tagId): Builder
    {
        return $query->whereHas('tags', fn (Builder $q) => $q->where('tags.id', $tagId));
    }

    // 完了/未完了で絞り込む
    public function scopeOfStatus(Builder $query, bool $status): Builder
    {
        return $query->where('status', $status);
    }
}
