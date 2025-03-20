setup-local-env-files:
	cp -R ./src/.env.example ./src/.env
	docker compose exec app php artisan key:generate

up:
	docker-compose up -d

up-with-build:
	docker-compose up -d --build

down:
	docker-compose down