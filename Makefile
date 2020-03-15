SHELL := /bin/bash

# Config vars
DEFAULT_ADMIN_PASSWORD := admin

CURRENT_DATE = `date "+%Y-%m-%d_%H-%M-%S"`

##
## General purpose
## ---------------
##

.DEFAULT_GOAL := help
help: ## Show this help.
	@printf "\n Available commands:\n\n"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-25s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m## */[33m/'
.PHONY: help

install: vendor node_modules assets start ## Install and start the project.
.PHONY: install

##
## Project
## -------
##

deploy: ## Deploy the project to production
	php bin\deployer.phar deploy prod
.PHONY: deploy

start: start-php ## Start the servers.
	-@docker-compose up --detach --remove-orphans
.PHONY: start

stop: ## Stop the servers.
	@printf $(SCRIPT_TITLE_PATTERN) "Server" "Stop PHP"
	-@symfony server:stop
	@printf $(SCRIPT_TITLE_PATTERN) "Server" "Stop DB"
	-@docker-compose stop
.PHONY: stop

restart: stop start ## Restart the servers.
.PHONY: restart

open: ## Open the web browser at the homepage
	@symfony open:local
.PHONY: open

cc: ## Clear the cache and warm it up.
	@printf $(SCRIPT_TITLE_PATTERN) "PHP" "Clear cache"
	-@symfony console cache:clear --no-warmup
	@printf $(SCRIPT_TITLE_PATTERN) "PHP" "Warmup cache"
	-@symfony console cache:warmup
.PHONY: cc

vendor: ## Install Composer dependencies.
	@printf ""$(SCRIPT_TITLE_PATTERN) "PHP" "Install Composer dependencies"
	composer install --optimize-autoloader --prefer-dist --no-progress
.PHONY: vendor

node_modules: ## Install Node.js dependencies.
	@printf ""$(SCRIPT_TITLE_PATTERN) "JS" "Install Node.js dependencies"
	@npm install

assets: ## Build frontend assets.
	@printf ""$(SCRIPT_TITLE_PATTERN) "JS" "Build frontend assets"
	@npm run-script dev
.PHONY: assets

assets-watch: ## Watch assets to rebuild them on change (runs in the foreground)
	@printf ""$(SCRIPT_TITLE_PATTERN) "JS" "Watch assets to rebuild them on change"
	@npm run-script watch
.PHONY: assets-watch

start-php:
	@printf $(SCRIPT_TITLE_PATTERN) "Server" "Start PHP"
	-@symfony server:stop >/dev/null 2>&1
	-@symfony server:start --daemon
.PHONY: start-php

dump: ## Dump the current database to keep a track of it.
	@printf $(SCRIPT_TITLE_PATTERN) "DB" "Dump current database to var/dump_$(CURRENT_DATE).sql"; \
	docker-compose exec -T database mysqldump -uroot -proot main > var/dump_$(CURRENT_DATE).sql
.PHONY: dump

##
## QA
## --
##

install-phpunit:
	@APP_ENV=test symfony php bin/phpunit --version
.PHONY: install-phpunit

phpunit: ## Execute the PHPUnit test suite
	@APP_ENV=test symfony php bin/phpunit
.PHONY: phpunit

qa: ## Execute QA tools
	$(MAKE) security-check
	$(MAKE) cs
	$(MAKE) phpstan
.PHONY: qa

security-check: ## Execute the Symfony Security checker
	@symfony security:check
.PHONY: security-check

phpstan: ## Execute PHPStan
	@printf "\n"$(SCRIPT_TITLE_PATTERN) "QA" "phpstan"
	@symfony php vendor/phpstan/phpstan/phpstan analyse
.PHONY: phpstan

cs: ## Execute php-cs-fixer
	@printf $(SCRIPT_TITLE_PATTERN) "QA" "php-cs-fixer"
	@symfony php bin/php-cs-fixer fix
.PHONY: cs

cs-dry: ## Execute php-cs-fixer with a DRY RUN
	@printf $(SCRIPT_TITLE_PATTERN) "QA" "php-cs-fixer"
	@symfony php bin/php-cs-fixer fix --dry-run
.PHONY: cs-dry

lint: ## Execute some linters on the project
	@printf $(SCRIPT_TITLE_PATTERN) "QA" "lint:yaml"
	@symfony console lint:yaml src config translations

	@printf $(SCRIPT_TITLE_PATTERN) "QA" "lint:container"
	@symfony console lint:container

	@printf $(SCRIPT_TITLE_PATTERN) "QA" "lint:twig"
	@symfony console lint:twig --show-deprecations
.PHONY: lint

# Helper vars
SCRIPT_TITLE_PATTERN := "\033[32m[%s]\033[0m %s\n"
SCRIPT_ERROR_PATTERN := "\033[31m[%s]\033[0m %s\n"
