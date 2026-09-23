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
        Schema::create('tags', function (Blueprint $table) {
            $table->id(); // レコードを一意に識別するための主キー
            $table->string('name'); // タグの名前, 文字列
            $table->string('color')->nullable(); // タグの色, 文字列, nullでも良い
            $table->timestamps(); // created_at, updated_atの両方を作成するためのヘルバー関数
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
