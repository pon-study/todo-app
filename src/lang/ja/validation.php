<?php

/*
バリデーションエラー時に日本語で出力するための設定
:attribute, :maxはLaravelがバリデーション時に自動で実際の値に置き換えるためのプレースホルダー
*/
return [
    'required' => ':attributeは必須入力です。',
    'string' => ':attributeは文字列で入力してください。',
    'max' => [
        'string' => ':attributeは:max文字以内で入力してください。',
    ],
    'date' => ':attributeは日付形式で入力してください。',
    'boolean' => ':attributeはtrueかfalseで指定してください。',
    'selected' => ':attributeに指定できない値が選択されています。',

    // 各フィールド名の日本語表示
    'attributes' => [
        'title' => 'タイトル',
        'description' => '詳細',
        'due_date' => '期限',
        'priority' => '優先度',
        'status' => '完了ステータス',
        'tags' => 'タグ',
        'name' => '名前',
        'color' => 'カラー',
    ],
];
