<?php

use App\Models\Todo;
use Livewire\Component;
use Livewire\Attributes\Computed;

new class extends Component
{
    #[Computed]
    public function events()
    {
        return Todo::whereNotNull('due_date') //due_dateがnullではないレコードに絞る
            ->get() // レコードを取得する
            ->map(fn ($todo) =>[ // title,startのキーを持つ連想配列を、レコードごとに用意する
                'title' => $todo->title,
                'start' => $todo->due_date->format('Y-m-d'),
            ]);
    }
};
?>

<div>
    {{-- wire:ignore: Livewire側でこのdivをDOM操作しないようにするための設定。 --}}
    {{-- FullCalendarはJS側でDOM操作を行う --}}
    {{-- toJson(): コレクションをJSON文字列に変換し、そのままdata-events属性の値として出力する。この文字列はJS側のJSON.parse()でそのまま読み取れる形式になっている --}}
    <div id="calendar" wire:ignore data-events="{{ $this->events->toJson(JSON_UNESCAPED_UNICODE) }}"></div>
</div>