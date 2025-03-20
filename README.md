# Memories (backend)

※ [English README.md is here！](/docs/README-english.md)👈

## なぜ作ってるか

僕は思い出を忘れがちな人で、最近Google Photosの「最近の思い出！4年前の写真！」の通知を見ると嬉しいのでいいことが起きた直後に思い出を投稿し、いい思い出を楽しく振り向くアプリを作成したいです！

つまり、日記版のGoogle Photosアプリです（笑）

## 何を学びたいか

僕はフロントエンドエンジニアだけどバックエンド開発の経験はほぼ０で自分の会社のバックエンドチームのやってることがあまり把握できてないため自分のバックエンド知識を深める目標です！

## ローカル環境構築

### 1. hostsファイルにドメイン追加

※ 僕のパソコンだとhostsファイルは /etc/hosts

```
127.0.0.1 local.memories.com
```

### 2. Clone project → コンテナ準備 → ローカル環境起動など

※ Docker Desktop は導入必須です。導入後Docker Desktopを開いてください

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