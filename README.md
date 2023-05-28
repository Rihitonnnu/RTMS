# RTMS(研究時間管理システム)

### ER 図

https://dbdiagram.io/d/63a851d87d39e42284e76cc0

## 環境構築

## クローン

```
git clone git@github.com:Rihitonnnu/RTMS.git
```

## プロジェクトセットアップ

### ビルドとコンテナ起動

```
docker compose up -d
```

### env ファイルコピー

```
cp .env.example .env
```

### コンテナに入る

```
docker compose exec app bash
```

### Composer インストール

```
composer install
```

### 認証キー作成

```
php artisan key:generate
```

### マイグレーション、シーディング

```
php artisan migrate:fresh --seed
```

## Vite セットアップ

### npm インストール(app コンテナ内)

```
npm install
```

### ビルド

```
#開発環境用
npm run dev

#本番環境用
npm run build
```
