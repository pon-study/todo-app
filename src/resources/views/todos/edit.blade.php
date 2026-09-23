<!DOCTYPE html>
<html>
<head>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">編集</h2>
            <a href="{{ route('todos.index') }}" class="btn-secondary">一覧・照会へ戻る</a>
        </div>
        <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT') {{-- update処理ではPUTとして認識させるため、hiddenでPUTを保持する --}}

            <div class="form-row items-start">
                <label class="form-label">タイトル<span class="required">*</span></label>
                <div class="flex flex-col flex-1">
                    <input type="text" name="title" value="{{ $todo->title }}" class="form-input" placeholder="例）肉を買う">
                    @error('title')
                    <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">詳細</label>
                <div class="flex flex-col flex-1">
                    <textarea name="description" class="form-textarea" placeholder="例）スーパー〇〇店で買う">{{ $todo->description }}</textarea>
                    @error('description')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">期限</label>
                <div class="flex flex-col flex-1">
                    <input type="date" name="due_date" value="{{ $todo->due_date?->format('Y-m-d') }}" class="form-input">
                    @error('due-date')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">優先度</label>
                <div class="flex flex-col flex-1">
                    <select name="priority" class="form-select">
                        <option value="">選択なし</option>
                        @foreach (\App\Enums\Priority::cases() as $option)
                            <option value="{{ $option->value }}" @selected($todo->priority === $option)>{{ $option->label() }}</option>
                        @endforeach
                    </select>
                    @error('priority')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">タグ</label>
                <div class="flex flex-col flex-1">
                <select name="tags[]" multiple class="form-select"> {{-- プルダウン複数選択 --}}
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->id }}" @selected($todo->tags->contains($tag))>{{ $tag->name }}</option>
                    @endforeach
                </select>
                    @error('tags')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">完了フラグ</label>
                <div class="flex flex-col flex-1 items-start">
                    <input type="hidden" name="status" value="0"> {{-- チェックボックスが入力されていない場合は0（false）として送信する --}}
                    <input type="checkbox" name="status" value="1" class="form-input" @checked($todo->status)>
                    @error('status')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">更新</button>
            </div>
        </form>
    </div>
    @livewireScripts
</body>
</html>