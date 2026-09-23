<!DOCTYPE html>
<html>
<head>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js']){{-- TailwindCSS・JSをビルド済みのアセットとして読み込むためのディレクティブ--}}    
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">カレンダー</h2>
            <a href="{{ route('todos.index') }}" class="btn-secondary">Todo一覧・照会へ戻る</a>
        </div>
        <livewire:calendar />
    </div>
    @livewireScripts
</body>
</html>