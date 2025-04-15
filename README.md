# Memories (backend)

※ [English README.md is here！](/docs/README-english.md)👈

## なぜ作ってるか

僕は思い出を忘れがちな人で、最近Google Photosの「最近の思い出！4年前の写真！」の通知を見ると嬉しいのでいいことが起きた直後に思い出を文字で投稿し、いい思い出を楽しく振り向くアプリを作成したいです！

つまり、日記版のGoogle Photosアプリです（笑）

## 何を学びたいか

僕はフロントエンドエンジニアだけどバックエンド開発の経験はほぼ０で自分の会社のバックエンドチームのやってることがあまり把握できてないため自分のバックエンド知識を深める目標です！

## ローカル環境構築

### 1. hostsファイルにドメイン追加

※ 僕のパソコンだとhostsファイルは `/etc/hosts` (M1以降の場合、 `/private/etc/hosts`)

```
127.0.0.1 local.memories.com
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

## おすすめのツール・Extensionなど

### VSCodeでデータベースの中身を見える化ツール
- [devdb (VSCode Extension)](https://github.com/damms005/devdb-vscode)