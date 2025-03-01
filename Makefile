.PHONY: install build up bash artisan

DC = docker compose
APP = time_sheet_app

build:
	@echo "Building containers..."
	$(DC) build

up:
	@echo "Starting containers..."
	$(DC) up -d

bash:
	$(DC) exec $(APP) bash

artisan:
	$(DC) exec $(APP) php artisan $(filter-out $@,$(MAKECMDGOALS))

install: build up
	@echo "prepare env"
	cp .env.example .env || true

	@echo "Generate app key"
	$(DC) exec $(APP) php artisan key:generate

	@echo "Database Migration"
	$(DC) exec $(APP) php artisan migrate:refresh
	$(DC) exec $(APP) php artisan optimize:clear

	@echo "Seeding data"
	$(DC) exec $(APP) php artisan db:seed

%:
	@:
