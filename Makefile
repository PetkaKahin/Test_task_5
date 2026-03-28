ifeq ($(OS),Windows_NT)
    COPY := copy
else
    COPY := cp
endif

init:
	$(COPY) .env.example .env
	docker compose up -d --build
	docker compose exec php-fpm composer install
	docker compose exec php-fpm php artisan key:generate
	docker compose exec php-fpm php artisan migrate --seed
up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

restart:
	docker compose restart

ps:
	docker compose ps

logs:
	docker compose logs -f

php:
	docker compose exec php-fpm sh

composer-install:
	docker compose exec php-fpm composer install

migrate:
	docker compose exec php-fpm php artisan migrate

fresh:
	docker compose exec php-fpm php artisan migrate:fresh --seed

stan:
	docker compose exec php-fpm ./vendor/bin/phpstan analyse

ide-helper:
	docker compose exec php-fpm php artisan ide-helper:generate

tests:
	docker compose exec php-fpm ./vendor/bin/pest