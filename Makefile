setup-local-env-files:
	cp -R ./src/.env.example ./src/.env
	docker compose exec app php artisan key:generate

app-bash:
	docker compose exec app bash

up:
	docker-compose up -d

up-with-build:
	docker-compose up -d --build

down:
	docker-compose down

app-migrate-refresh-seed:
	docker compose exec app php artisan migrate:refresh --seed
