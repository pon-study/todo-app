<!DOCTYPE html>
<html lang="ja">
<head>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">Todo 一覧・照会</h2>
            <div class="flex gap-3">
                <a href="{{ route('calendar.index')}}" class="btn-secondary">カレンダー</a>
                <a href="{{ route('tags.index')}}" class="btn-secondary">タグ管理</a>
                <a href="{{ route('todos.create')}}" class="btn-primary">新規登録</a>
            </div>
        </div>
        <livewire:todo-list />
    </div>
        @livewireScripts

</body>
</html>