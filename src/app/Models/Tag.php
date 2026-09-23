<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // fillable: INSERT時に一括で代入できるカラムを指定するためのもの。
    // セキュリティ的な観点で、指定しておくと意図しないカラムへのINSERTを防ぐことができる。
    protected $fillable = ['name', 'color'];

    public function todos()
    {
        // belongsToManyは、Laravelが提供するEloquentで使用することができるメソッド
        // 多対多（Many-to-Many）の関係を定義するためのメソッド
        // 中間テーブル（tag_todoテーブル）を自動でJOINする仕組み
        return $this->belongsToMany(Todo::class);
    }
}
