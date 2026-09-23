# PHP:8.4-fpmを使用
FROM php:8.4-fpm

# Dockerイメージのビルド時に実行するコマンド
# git, unzip：Composerからパッケージを取得する際にgitやzip形式ものを取得できるようにインストール
# curl: HTTPリクエスト（API, データ取得）で必要
# ca-certificates: SSL/TLS通信の検証（※Composer等の依存パッケージ取得時に使用）
# gnupg: 暗号化・署名検証（※Composer等の依存パッケージ取得時に使用）
# libpq-dev: PostgreSQLライブラリ
# libonig-dev: 正規表現ライブラリ
# Node.jsのセットアップ
# PHP拡張機能（pdo,pdo_pgsql: PostgreSQL接続用、mbstring: 日本語などのマルチバイト文字列処理用）
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    ca-certificates \
    gnupg \
    libpq-dev \
    libonig-dev \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql pgsql mbstring

# composer2系（常に2系の最新版）をDocker Hub（外部のイメージレジストリ）から取得
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# コマンド実行時のカレントディレクトリ
WORKDIR /var/www/html

# コンテナ起動時の事前処理を実行するため、ホスト側に事前処理用シェルファイルを一旦コピーする
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# 9000ポートを使用することを宣言
EXPOSE 9000

# 事前処理の実行
ENTRYPOINT [ "entrypoint.sh" ]

# コンテナを起動後、php-fpmを実行
CMD ["php-fpm"]