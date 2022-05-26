init:
	@echo "-----------Doing fresh Installation-----------"

	## Prepare Env File
	cp .env.example .env

	## Start the Project
	docker-compose up -d --build --remove-orphans

exec:
	docker exec -it app bash

start:
	docker-compose up -d --remove-orphans

restart:
	docker restart app

build:
	docker-compose up -d --build app

migration-diff:
	docker exec -it app php artisan doctrine:migrations:diff

migrate:
	docker exec -it app php artisan doctrine:migrations:migrate

fetch:
	docker exec -it app php artisan user:fetch 100 au
