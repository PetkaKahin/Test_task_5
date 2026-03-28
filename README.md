# Тестовое задание №5

## Описание

REST API для управления списком задач (To-Do List) на Laravel.

### Основные особенности

- **Строгая типизация** — проект проходит Larastan на максимальном уровне (`level: max`)
- **API Resources** — все endpoints возвращают ресурсы и коллекции ресурсов
- **Тесты** — покрытие API тестами через Pest
- **Docker** — Nginx + PHP-FPM + MySQL

## Стек

- PHP 8.3
- Laravel 13
- MySQL 9.0
- Pest (тесты)
- Larastan (статический анализ)
- Docker (Nginx + PHP-FPM + MySQL)

## Установка

### Docker

```bash
make init
```

### Ручная

```bash
cp .env.example .env

composer install
php artisan key:generate
php artisan migrate --seed
```

## Makefile-команды

| Команда                 | Описание                     |
|-------------------------|------------------------------|
| `make init`             | Перавая установка приложения |
| `make up`               | Запустить контейнеры         |
| `make down`             | Остановить контейнеры        |
| `make build`            | Пересобрать и запустить      |
| `make restart`          | Перезапустить контейнеры     |
| `make ps`               | Статус контейнеров           |
| `make logs`             | Логи контейнеров             |
| `make php`              | Зайти в контейнер PHP        |
| `make composer-install` | Установить зависимости       |
| `make migrate`          | Запустить миграции           |
| `make fresh`            | Пересоздать БД с сидами      |
| `make stan`             | Запустить Larastan           |
| `make tests`            | Запустить тесты (Pest)       |
| `make ide-helper`       | Сгенерировать IDE-helper     |