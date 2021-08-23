#!/usr/bin/make

RT = $(shell pwd)

-include .env

export


define print
	printf " \033[33m[%s]\033[0m \033[32m%s\033[0m\n" $1 $2
endef
define printTabbed
	printf " \e[30;48;5;82m  %s  \033[0m\n" $1
endef

.DEFAULT_GOAL := help

help:
	@echo "Скрипт содержащий общие команды для настройки, билда и тестирования приложения"
	@printf "\n\033[33mПеред первым запуском требуется выполнить make init\n\n"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-$(tabSize)s\033[0m %s\n", $$1, $$2}'

init: | env docker-build

docker-build: build up vendor seed key

key:
	@docker-compose exec --user www-data php-apache php artisan key:generate

build:
	docker-compose build --build-arg UID=$$(id -u) --build-arg GID=$$(id -g)

up:
	docker-compose up --detach

down:
	docker-compose down

restart: down up

test:
	@docker-compose exec --user www-data php-apache php artisan test

seed:
	@docker-compose exec --user www-data php-apache php artisan migrate:fresh --seed

vendor:
	@docker-compose exec --user www-data php-apache composer install --no-interaction

env:
ifeq (,$(wildcard $(envfile)))
	@echo 'copying .env.example ...'
	@cp .env.example .env
	@sed -i "s/CURRENT_USER=/CURRENT_USER=$$(id -u)/" .env
	@sed -i "s/CURRENT_GROUP=/CURRENT_GROUP=$$(id -g)/" .env
	@echo 'copied and injected environment parameters'
else
	@echo '.env already exists, skipping copying'
endif
