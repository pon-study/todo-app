<?php

/*
Todoの新規登録を行う際のバリデーションファイル
*/

namespace App\Http\Requests;

use App\Enums\Priority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreTodoRequest extends FormRequest
{
    /**
     * 全ユーザーを許可
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Todoの新規登録時におけるルール
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255', // 必須、文字列であること、255文字まで
            'description' => 'nullable|string', // null許可、文字列であること
            'due_date' => 'nullable|date', // null許可、日付形式であること
            'priority' => ['nullable', new Enum(Priority::class)], // null許可、優先度の定数クラスに記載している値のみ
            'status' => 'boolean', // false/trueの形式であること
        ];
    }
}
