# Commands

```sh
#  Start containers
$ docker-compose up -d
# Builds first before starting containers
$ docker-compose up -d --build
$ docker compose exec app bash
$ docker-compose exec db bash
$ docker compose exec db mysql -V
$ docker-compose exec web nginx -v
$ mysql -u root -p
# Seeding all
$ php artisan db:seed
# Seeding specific seeder
$ php artisan db:seed --class=BooksSeeder
$ php artisan make:model RankingInfo -m
$ php artisan make:model Book --migration
$ php artisan make:controller BookController --api
$ php artisan make:seeder RankingPostSeeder
# When you add a new column:
$ php artisan migrate
$ php artisan db:seed
# To redo a migration with a db that already exists
$ php artisan migrate:refresh
$ php artisan migrate:refresh --seed
$ php artisan make:test ApiBlogControllerTest
$ php artisan test
$ php artisan route:list
```