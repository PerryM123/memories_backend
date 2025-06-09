setup-local-env-files:
	cp -R ./src/.env.example ./src/.env
	cp -R .devdbrc.example .devdbrc
	docker compose exec app php artisan key:generate

app-bash:
	docker compose exec app bash

redis-cli:
	docker compose exec redis redis-cli

db-bash:
	docker compose exec db bash

up:
	 docker-compose up -d app web db minio

up-all:
	docker-compose up -d

up-with-build:
	docker-compose up -d --build

down:
	docker-compose down

app-migrate-refresh-seed:
	docker compose exec app php artisan migrate:refresh --seed

laravel-log:
	tail -f src/storage/logs/laravel.log

mysql:
	docker compose exec db mysql -u root -p

e2e-env-up:
	docker-compose -f docker-compose.e2e.yml --env-file ./src/.env.e2e-testing up -d

e2e-env-down:
	docker-compose -f docker-compose.e2e.yml --env-file ./src/.env.e2e-testing down

e2e-migrate:
	docker-compose -f docker-compose.e2e.yml --env-file ./src/.env.e2e-testing exec app php artisan migrate:refresh --seed
