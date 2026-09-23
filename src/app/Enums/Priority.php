<?php

/*
定数を管理するファイル
*/

namespace App\Enums;

enum Priority: int
{
    // 優先度を数値で管理する
    // 今後の多言語対応時に数値をベースとして分岐させるため
    case High = 1;
    case Medium = 2;
    case Low = 3;

    public function label(): string
    {
        // このクラスファイル内の変数と一致した場合の右辺を戻り値として返す
        // match()は、'==='として比較するため、型も一致しないと返さない
        return match ($this) {
            self::High => '高',
            self::Medium => '中',
            self::Low => '低',
        };
    }
}
