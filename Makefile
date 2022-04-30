SHELL=/bin/bash

build:
	docker-compose build

up:
	USER_NAME=$(shell id -nu) USER_ID=$(shell id -u) GROUP_NAME=$(shell id -ng) GROUP_ID=$(shell id -g) docker-compose up -d

stop:
	docker-compose stop

down:
	docker-compose down

docker-build:
	docker-compose build

ps:
	docker ps

shell:
	docker exec -it laravel8-template-app /bin/bash

work:
	docker exec -it laravel8-template-app su -s /bin/bash $(shell id -un)

mysql:
	docker exec -it laravel8-template-mysql bash -c 'mysql -u user -ppassword'

models:
	php artisan -N ide-helper:models

fresh:
	php artisan migrate:fresh --seed

ide-helper:
	php artisan ide-helper:generate
	php artisan ide-helper:models --nowrite
	php artisan ide-helper:meta

api-generate:
	php artisan openapi:generate > ./dist/openapi.json
