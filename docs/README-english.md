# Split My Receipt Up (Backend)

※ [日本語のREADME.mdはここ！](./../README.md)👈

## Why am I Making This?
Instead of calculating receipts by hand, let's use AI's OCR instead to convert a photo of a receipt into a machine-readable text format and calculate it that way!

## What I Want to Learn From Making This?
I've never had the chance to work in the backend of web development so I will take this oppurtunity to use Laravel and make an application following Domain-Driven Design (DDD) principles (reference: https://github.com/PerryM123/memories_backend). This repository will be for the frontend and using frontend tools I want to get into. For example: vitest, playwright, tailwindcss, figma, etc）

## Related Repositories

### API Documentation Repository (Swagger)
- [PerryM123/split-my-receipt-up-swagger-doc](https://github.com/PerryM123/split-my-receipt-up-swagger-doc)

### Frontend
- [PerryM123/split-my-receipt-up-frontend](https://github.com/PerryM123/split-my-receipt-up-frontend/blob/master/docs/README-english.md)

### Mock Environment

Since using OpenAI API requires tokens, this mock environment will act as OpenAI during my development progress.
- [PerryM123/OpenAI API Mock Environment (Split My Receipt Up)](https://github.com/PerryM123/open-ai-api-mock-environment/blob/master/docs/README-english.md)

## Simple BFF Architecture
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

## Milestones
- [x] Dockerize everything for my app: 
	- Laravel App
	- Mysql Database
	- Nginx
	- Local S3 (MinIO)
- [x] Build the backend using Domain Driven Design
- [x] Setup external APIs (OpenAI API) to be used within my app
- [x] Integrate Bearer tokens so that only Nuxt can make requests to the laravel API
- [ ] Add Swagger (OpenAPI) and host on github pages
- [ ] Add Laravel-Pint or tighten-duster for linting and formatting
- [ ] Make unit and integration tests
- [ ] Release the prototype as `v0.1.0`
- [ ] Login integration w/ redis to use session storage
- [ ] Deploy containers to a VPS or EC2
- [ ] Make optimizations on the database to speed up response times
- [ ] Integrate Rate Limiting for requests based on IP addresses or emails

## Useful Tools and Extension

### View the contents of the database in VSCode
- [devdb (VSCode Extension)](https://github.com/damms005/devdb-vscode)