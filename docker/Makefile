include docker.mk

.PHONY: composer artisan npm install reinstall

PHP_VER ?= 8.0
COMPOSER_ROOT ?= /var/www/html

composer:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") composer --working-dir=$(COMPOSER_ROOT) $(filter-out $@,$(MAKECMDGOALS))

artisan:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") ./artisan $(filter-out $@,$(MAKECMDGOALS))

install:
	make artisan migrate
	make artisan db:seed

reinstall:
	make artisan migrate:fresh
	make artisan db:seed
npm:
	cd ../app && npm $(filter-out $@,$(MAKECMDGOALS))

