#!/bin/sh
#appコンテナを起動した際に実行する事前処理シェルスクリプト
set -e

FIRST_BOOT=false
#vendorディレクトリの存在チェック
if [ ! -d vendor ]; then
    FIRST_BOOT=true
    composer install --no-interaction --optimize-autoloader ##パッケージのインストール（自動処理のため対話的な質問はスキップ、クラス読み込み時のパフォーマンス最適化）
fi

#.envファイルの存在チェック
if [ ! -f .env ]; then
    cp .env.example .env #テンプレートをコピーする
fi

# LaravelのAPP_KEYの存在チェック
if ! grep -q "^APP_KEY=base64" .env; then
    php artisan key:generate --force #既存値でAPP_KEYを上書き作成
fi

# Node.jsの依存パッケージの存在チェック
if [ ! -d node_modules ]; then
    npm ci # package-lock.jsonに記載しているバージョンのパッケージをインストールする
fi

# buildディレクトリの存在チェック（フロントエンドビルド用）
if [ ! -d public/build ]; then
    npm run build #JavaScript, CSSを最適化してpublic/buildに出力
fi

# vendorディレクトリを追加した場合
if [ "$FIRST_BOOT" = true ]; then
    php artisan migrate --force --seed # マイグレーション実行+ダミーデータの挿入
else
    php artisan migrate --force # マイグレーションのみ実行
fi

exec "$@"