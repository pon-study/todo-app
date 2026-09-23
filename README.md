# ToDo管理アプリ

Laravel + Livewire + Tailwind CSS + PostgreSQL で構築した個人学習用のToDo管理アプリです。

## 主な機能

- Todoの登録・編集・削除・一覧照会（優先度／タグ／完了状態で絞り込み可能）
- タグ管理（登録・編集・削除、タグごとの色分け表示）
- カレンダー表示（FullCalendar.js）

## セットアップ

必要なもの：Docker / Docker Compose

```bash
git clone https://github.com/pon-study/todo-app.git
cd todo-app
docker compose up -d --build
```

初回起動時に、コンテナ内でcomposer install・.env作成・APP_KEY生成・マイグレーション・シーディング・フロントエンドのビルドが自動実行されます（数分かかります）。

起動後、以下にアクセスしてください。

http://localhost:8080

## テストを実行する場合

別途テスト用DB（\`todo_app_test\`）の作成が必要です。

```bash
docker compose exec db psql -U todo_user -d postgres -c "CREATE DATABASE todo_app_test;"
docker compose exec app php artisan test
```

## 使用技術

| 分類 | 技術 |
| --- | --- |
| 言語 | PHP 8.4 |
| フレームワーク | Laravel 13 |
| フロントエンド連携 | Livewire 4 |
| CSS | Tailwind CSS 4 |
| ビルドツール | Vite 8 |
| カレンダー表示 | FullCalendar.js 6 |
| データベース | PostgreSQL 16 |
| Webサーバー | Nginx 1.27 |
| テスト | PHPUnit 12 |
| 実行環境 | Docker / Docker Compose |
