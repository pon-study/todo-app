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
        Schema::create('tag_todo', function (Blueprint $table) {
            $table->foreignId('todo_id')->constrained()->cascadeOnDelete(); // 外部キー制約をつけ、todos.idカラムを参照する
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete(); // 外部キー制約をつけ、tags.idカラムを参照する
            $table->primary(['todo_id', 'tag_id']); // 複合主キーの設定（※todo_id,tag_idの2つを合わせて一つの主キーとすること）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_todo');
    }
};
