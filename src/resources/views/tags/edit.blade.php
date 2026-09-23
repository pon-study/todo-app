<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">タグ編集</h2>
            <a href="{{ route('tags.index') }}" class="btn-secondary">一覧へ戻る</a>
        </div>
        <form action="{{ route('tags.update', $tag->id) }}" method="POST" class="form-container">
            @csrf
            @method('PUT')
            <div class="form-row items-start">
                <label class="form-label">タグ名<span class="required">*</span></label>
                <div class="flex flex-col flex-1">
                    <input type="text" name="name" value="{{ $tag->name }}" class="form-input" placeholder="例）買い物">
                    @error('name')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-row items-start">
                <label class="form-label">カラー</label>
                <div class="flex flex-col flex-1">
                    <input type="text" name="color" value="{{ $tag->color }}" class="form-input"  placeholder="例）#FF0000">
                    @error('color')
                        <p class="error-text">{{ $message }}</p> {{-- バリデーションエラー時のメッセージ出力 --}}
                    @enderror
                </div>
            </div>

            <div class="form-actions">
            <button type="submit" class="btn-primary">更新</button>
            </div>
        </form>
    </div>
</body>
</html>