# Split My Receipt Up (Backend)

※ [English README.md is here！](/docs/README-english.md)👈

## なぜ作ってるか

レシートを見て手動で計算するよりAIのOCR（文字認識）でレシートの文字を取得し計算してくれるアプリは制作したいです！


## 何を学びたいか

僕は今までフロントエンド開発しかやったことがなく、あまりバックエンドの知識が深くなく、本格的にバックエンド開発をする機会もなく、バックエンドチームともっと話し合いできるように「バックエンドはどう動いてるか？バックエンドだと何を考慮するべきか？」ということを学ぶ目標をしてます。
なのでLaravelでドメイン駆動設計(DDD)を実践しつつ気になるフロントエンドツールとフレームワーク（vitest、playwright、tailwindcss、figmaなど）を活用します！

今のリポジトリはフロントエンド用で、バックエンド側は以下です！
- [PerryM123/memories_backend](https://github.com/PerryM123/memories_backend)

## 簡単なアーキテクチャ設計
![alt text](/docs/images/simple-architecture.jpg)

## ワイヤーフレーム
- [figmaワイヤー](https://www.figma.com/design/5YJWfJxPOz41nTYUs3Ecsv/Split-Me-Up-Before-You-Go-Go?node-id=0-1&t=pg6lQGz4q81qqjrR-1)

![alt text](/docs/images/wireframe.jpg)

## ローカル環境構築

### 1. hostsファイルにドメイン追加

※ 僕のパソコンだとhostsファイルは `/etc/hosts` (M1以降の場合、 `/private/etc/hosts`)

```sh
# laravel app
127.0.0.1 local.memories.com
# local s3 storage
127.0.0.1 minio
```

### 2. Clone project → コンテナ準備 → ローカル環境起動など

> [!WARNING]
> Docker Desktop は導入必須です。導入後Docker Desktopを開いてください

```sh
$ cd ~/workspace
$ git clone git@github.com:PerryM123/memories_backend.git
$ cd memories_backend
# コンテナのビルドです. もし既にビルドを実行されたら $ make up-with-build で再ビルドできます
$ make up
$ make setup-local-env-files
```

### 3. ローカルのページを開く

うまくいけば http://local.memories.com/ で開くことができます。

※ http://localhost:8081/ からアクセスも可能！

# 環境構築に対するあるあるの問題と解決方法

## make setup-local-env-filesでFailed to open stream: No such file or directoryエラーが発生した場合

### エラー内容:
```
$ make setup-local-env-files
cp -R ./src/.env.example ./src/.env
cp -R .devdbrc.example .devdbrc
docker compose exec app php artisan key:generate
PHP Warning:  require(/app/vendor/autoload.php): Failed to open stream: No such file or directory in /app/artisan on line 18

Warning: require(/app/vendor/autoload.php): Failed to open stream: No such file or directory in /app/artisan on line 18
PHP Fatal error:  Uncaught Error: Failed opening required '/app/vendor/autoload.php' (include_path='.:/usr/local/lib/php') in /app/artisan:18
Stack trace:
#0 {main}
  thrown in /app/artisan on line 18

Fatal error: Uncaught Error: Failed opening required '/app/vendor/autoload.php' (include_path='.:/usr/local/lib/php') in /app/artisan:18
Stack trace:
#0 {main}
  thrown in /app/artisan on line 18
exit status 255
make: *** [setup-local-env-files] Error 255
```

### 解決方法

下記のコマンドを実行すると問題なく http://local.memories.com/ を開けます。

```sh
$ make app-bash
root@584ffe96183c:/app# composer install
root@584ffe96183c:/app# exit
$ make setup-local-env-files
```

## Milestones
- [x] 以下、アプリが利用するものをコンテナ内で動かすようにdocker化
	- Laravel App
	- Mysql Database
	- Nginx
	- Local S3 (MinIO)
- [x] ドメイン駆動設計にバックエンドを実装
- [x] 外部API(OpenAI API)を呼び出すように実装
- [ ] NuxtのみがLaravel APIを叩けるようにBearer tokensを追加
- [ ] 単体テストと結合テストを追加
- [ ] プロトタイプは完了になると `v0.1.0` としてリリース
- [ ] セッションストレージとしてredisを利用するようにログインを実装
- [ ] VPSまたはEC2にデプロイ
- [ ] APIレスポンスの時間を早くするようにデータベースの最適化を行う
- [ ] IPアドレスとメルアドによってレート制限するように実現

## おすすめのツール・Extensionなど

### VSCodeでデータベースの中身を見える化ツール
- [devdb (VSCode Extension)](https://github.com/damms005/devdb-vscode)