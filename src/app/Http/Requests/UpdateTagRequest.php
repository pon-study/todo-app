<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTagRequest extends FormRequest
{
    // 全ユーザ許可
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255', // リクエストにキーが入っているときのみ => 必須、文字列、最大255文字
            'color' => 'nullable|string|max:255', // null許可、文字列、最大255文字
        ];
    }
}
