# Commands

## Start containers
```sh
$ docker-compose up -d
```

## Builds first before starting containers:

```sh
$ docker-compose up -d --build
```

## Enter containers through bash
```sh
$ docker compose exec app bash
$ docker-compose exec db bash
```

## Enter commands from outside of containers
```sh
$ docker compose exec db mysql -V
$ docker-compose exec web nginx -v
```

## Enter database's mysql
```sh
$ docker compose exec db bash
$ mysql -u root -p
```

## Data seeding
```sh
$ php artisan db:seed
```

## Seeding specific seeder
```sh
$ php artisan db:seed --class=BooksSeeder
```

## After adding a new column
```sh
$ php artisan migrate
$ php artisan db:seed
```

## Commands for making models/controllers/seeders
```sh
$ php artisan make:model RankingInfo -m
$ php artisan make:model Book --migration
$ php artisan make:controller BookController --api
$ php artisan make:seeder RankingPostSeeder
```
## Redo a migration with a database that already exists
```sh
$ php artisan migrate:refresh
$ php artisan migrate:refresh --seed
```

```sh
$ php artisan make:test ApiBlogControllerTest
$ php artisan test
```

## Show available routes for project
```sh
$ php artisan route:list
```

## Make a middleware
```sh
$ php artisan make:middleware VerifyAuthBearerToken
```

## MySQL Commands
```sql
-- List of databases
show databases;

-- Use database
use DB_NAME_HERE

-- Show column info from a table
show columns from TABLE_NAME_HERE;

-- Select command example
select * from TABLE_NAME_HERE;
```

## Import database

```sh
export MYSQL_ROOT_PASSWORD=password
docker compose exec -T db mysql -u root -p"$MYSQL_ROOT_PASSWORD" memories_database < ./.db_backups/mysql_backup_example.sql
```

# Redis

## check all data in redis session 

```sh
keys *
```

# Other
- Local environment: http://local.memories.com/ or http://localhost:8081/
- print objects in test files: `echo $response->getContent()`
