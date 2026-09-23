<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table) {
            $table->id(); // レコードを一意に識別するための主キー
            $table->string('title'); // Todoのタイトル
            $table->text('description')->nullable(); // Todoの説明文。string型は255文字までしか許可できないため、text型を採用。任意のためnullを許可
            $table->unsignedTinyInteger('priority')->nullable(); // Todoの優先度。unsignedは非負を示し、TinyIntegerは2バイトの整数（smallint）。任意のためnullを許可。※PostgreSQLではunsignedは適用されないが、非負の値であることを明示するために記載。
            $table->date('due_date')->nullable(); // Todoの期限。日付なのでstring型ではなくてdate型を採用。任意のためnullを許可（nullの場合は期限を設けない）
            $table->boolean('status')->default(false); // Todoの未完了/完了を示すためのステータス
            $table->timestamps(); // created_at, updated_atの両方を作成するためのヘルバー関数
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
