<!DOCTYPE html>
<html>
<head>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">新規登録</h2>
            <a href="{{ route('todos.index') }}" class="btn-secondary">一覧・照会へ戻る</a>
        </div>
        <form action="{{ route('todos.store') }}" method="POST" class="form-container">
            @csrf {{-- LaravelではデフォルトでCSRF保護が有効になっており、CSRFトークンをhiddenで保有するために記載が必要 --}}

            <div class="form-row items-start">
                <label class="form-label">タイトル<span class="required">*</span></label>
                <div class="flex flex-col flex-1">
                    <input type="text" name="title" value="{{ old('title') }}" class="form-input" placeholder="例）肉を買う"> {{-- value="{{ old('title') }}" は直前の入力をそのまま復元する--}}
                    @error('title')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">詳細</label>
                <div class="flex flex-col flex-1">
                    <textarea name="description" class="form-textarea" placeholder="例）スーパー〇〇店で買う"></textarea>
                    @error('description')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">期限</label>
                <div class="flex flex-col flex-1">
                    <input type="date" name="due_date" class="form-input">
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
                        @foreach (\App\Enums\Priority::cases() as $option) {{-- Enumから定義を取得 --}}
                            <option value="{{ $option->value }}">{{ $option->label() }}</option>
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
                    <select name="tags[]" class="form-select" multiple> {{-- プルダウン複数選択 --}}
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    @error('tags')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">登録</button>
            </div>
        </form>
    </div>
    @livewireScripts
</body>
</html>