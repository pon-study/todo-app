<!DOCTYPE html>
<html>
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">タグ管理</h2>
            <div class="flex gap-3">
                <a href="{{ route('todos.index') }}" class="btn-secondary">Todo 一覧・照会</a>
                <a href="{{ route('tags.create') }}" class="btn-primary">新規登録</a>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr class="table-head-row">
                    <th class="table-th">タグ</th>
                    <th class="table-th">カラー</th>
                    <th class="table-th">編集 / 削除</th>
                </tr>
            </thead>
            <tbody class="table-body">
                @foreach ($tags as $tag)
                <tr>
                    {{-- タグ --}}
                    <td class="table-td">{{ $tag->name }}</td>

                    {{-- カラー --}}
                    <td class="table-td" style="color: {{$tag->color}};">{{ $tag->color }}</td>

                    {{-- 編集/削除 --}}
                    <td class="table-td-action">
                        <a href="{{ route('tags.edit', $tag->id) }}" class="link-edit">編集</a>
                        <span>/</span>
                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE') {{-- Laravelのresource上では、削除処理はDELETEリクエストとして扱うため、DELETEをhiddenで保持する --}}
                            <button type="submit" class="link-delete">削除</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>