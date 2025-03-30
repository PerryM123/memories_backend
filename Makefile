setup-local-env-files:
	cp -R ./src/.env.example ./src/.env
	cp -R .devdbrc.example .devdbrc
	docker compose exec app php artisan key:generate

app-bash:
	docker compose exec app bash

db-bash:
	docker compose exec db bash

up:
	docker-compose up -d

up-with-build:
	docker-compose up -d --build

down:
	docker-compose down

app-migrate-refresh-seed:
	docker compose exec app php artisan migrate:refresh --seed
