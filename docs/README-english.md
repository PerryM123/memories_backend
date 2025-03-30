# Memories (backend)

※ [日本語のREADME.mdはここ！](./../README.md)👈

## Why am I Making This?
I tend to forget things after they happen and I love Google Photos' "New Memory For You! 4 Years" notification so I want to make an app I can quickly jot down a fun moment/thought right after it happens so that I can later reminisce about them.

So basically, a journal version of Google Photos w/ notifications.

## What I Want to Learn From Making This?

I am frontend engineer but I lack backend experience and have a hard time understanding what the backend teams are doing at my company so I'm using this oppurtunity to learn a bit of backend development to improve my understanding of backend development.

## Setup Local Environment

### 1. Add local domain to hosts file

※ In my case, my hosts file is located: /etc/hosts

```
127.0.0.1 local.memories.com
```

### 2. Clone project & docker & make commands

> [!WARNING]
> Docker Desktop is required. After installation, be sure to open it

```sh
$ cd ~/workspace
$ git clone git@github.com:PerryM123/memories_backend.git
$ cd memories_backend
# Build container. If you already built project before, instead, use: $ make up-with-build 
$ make up
$ make setup-local-env-files
```

### 3. Open local page

You should be able to see the laravel application using the local url: http://local.memories.com/

※ Also accesible from: http://localhost:8081/

## 他の便利なツール

- [devdb (VSCode Extension)](https://github.com/damms005/devdb-vscode)