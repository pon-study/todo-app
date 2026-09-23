<?php

/*
Todoの更新をする際のバリデーションを実行するファイル
*/

namespace App\Http\Requests;

use App\Enums\Priority;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest; // Laravelが標準で用意しているバリデーションルールクラス
use Illuminate\Validation\Rules\Enum; // 優先度の定数クラスを使用するために読み込む

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * このメソッドを使用するユーザーは許可されているかどうかチェックするためのメソッド
     */
    public function authorize(): bool
    {
        return true;
        // 今回は全ユーザーが使用できる想定のため、許可
    }

    /**
     * Get the validation rules that apply to the request.
     * バリデーションのルールを定義するためのメソッド
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255', // 必須、文字列のみ、255文字まで（※必須であるが、ステータス更新等でリクエストに送られないときは、sometimesをつけることでスキップできる。）
            'description' => 'nullable|string', // nullを許可、文字列のみ
            'due_date' => 'nullable|date', // nullを許可、日付のみ
            'priority' => ['nullable', new Enum(Priority::class)], // null許可、Priority enum（1=高/2=中/3=低）の値のみ許可
            'status' => 'boolean', // false/trueのみ
        ];
    }
}
