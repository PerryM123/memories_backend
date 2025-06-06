# Split My Receipt Up (Backend)

※ [日本語のREADME.mdはここ！](./../README.md)👈

## Why am I Making This?
Instead of calculating receipts by hand, let's use AI's OCR instead to convert a photo of a receipt into a machine-readable text format and calculate it that way!

## What I Want to Learn From Making This?
I've never had the chance to work in the backend of web development so I will take this oppurtunity to use Laravel and make an application following Domain-Driven Design (DDD) principles (reference: https://github.com/PerryM123/memories_backend). This repository will be for the frontend and using frontend tools I want to get into. For example: vitest, playwright, tailwindcss, figma, etc）

## Simple Architecture
![alt text](/docs/images/simple-architecture.jpg)

## Wireframe
- [figma design](https://www.figma.com/design/5YJWfJxPOz41nTYUs3Ecsv/Split-Me-Up-Before-You-Go-Go?node-id=0-1&t=pg6lQGz4q81qqjrR-1)

![alt text](/docs/images/wireframe.jpg)

## Setup Local Environment

### 1. Add local domains to hosts file

※ In my case, my hosts file is located: /etc/hosts (For anything like M1 or after, it is located: /private/etc/hosts)

```sh
# laravel app
127.0.0.1 local.memories.com
# local s3 storage
127.0.0.1 minio
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

# Common Pitfalls with Preparing Local Environment And How To Solve Them

## After doing make setup-local-env-files, Failed to open stream: No such file or directory

### Error Info:
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

### How to fix

The commands below should fix it and you'll be able to open http://local.memories.com/

```sh
$ make app-bash
root@584ffe96183c:/app# composer install
root@584ffe96183c:/app# exit
$ make setup-local-env-files
```

## Useful Tools and Extension

### View the contents of the database in VSCode
- [devdb (VSCode Extension)](https://github.com/damms005/devdb-vscode)